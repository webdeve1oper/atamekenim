<?php

namespace App\Http\Controllers\Frontend;

use App\AddHelpType;
use App\CashHelpSize;
use App\CashHelpType;
use App\City;
use App\Destination;
use App\Fond;
use App\FondDonation;
use App\Help;
use App\HelpDoc;
use App\HelpImage;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Region;
use App\Scenario;
use Carbon\Carbon;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class FondController extends Controller
{
    public function fond($id)
    {
        $expiresAt = Carbon::now()->addMinutes(5);
        $fond = Cache::remember('fond'.$id, $expiresAt, function() use ($id){
            return Fond::where('id', $id)->with('projects')->with('helps')->first();
        });
        if($fond->status == false or $fond->status == 0 or $fond->status == 2){
            return abort(404);
        }
        $baseHelpTypes = Cache::remember('fond'.$id, $expiresAt, function() use ($id){
            return AddHelpType::all();
        });
        $regions = Region::select('region_id', 'title_ru as text')->where('country_id', 1)->with('districts')->get();
        $destinations = Destination::all();
        $cashHelpTypes = CashHelpType::all();
        $cashHelpSizes = CashHelpSize::all();
        $relatedHelpIds = $fond->baseHelpTypes->pluck('id')->toArray();
        $relatedFonds = Fond::select('id','logo', 'title_ru', 'title_kz')->where('id', '!=', $fond->id)->whereHas('baseHelpTypes', function ($query) use ($relatedHelpIds) {
            $query->whereIn('id', $relatedHelpIds);
        })->where('status', 1)->get();

        return view('frontend.fond.fond')->with(compact('fond', 'baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes', 'relatedFonds'));
    }

    public function requestHelp(Request $request, $help_id = null)
    {
        if ($request->method() == 'POST') {
            $is_created = false;
            Log::info($request->all());
//            Log::info(Auth::user()->id);
                $validator = validator::make($request->all(), [
                    'body' => 'required|min:3',
                    'baseHelpTypes.*' => 'required',
                    'cashHelpTypes.*' => 'required',
                ], [
                    'body.required' => 'заполните описание',
                    'body.min' => 'заполните описание',
                ]);
                $request['user_id'] = Auth::user()->id;

                if ($validator->fails()) {
                    return redirect()->back()->with('error', $validator->errors()->getMessages())->withInput();
                }

//                if (Help::where('user_id', Auth::user()->id)->where('admin_status', 'moderate')->count() >= 1 and $help_id == null) {
//                    return redirect()->back()->with('error', __('cabinet-appl.error_before_create_help'));
//                }

                $data = $request->all();
                if (array_key_exists('city_id', $data)) {
                    if ($data['city_id'] == 0) {
                        unset($data['city_id']);
                    }
                }
                if (array_key_exists('district_id', $data)) {
                    if ($data['district_id'] == 0) {
                        unset($data['district_id']);
                    }
                }

                $data['statuses'] = $this->getPersonStatus(Auth::user()->iin);
                if ($request->help_id) {
                    $help = Help::find($request->help_id);
                    $data['admin_status'] = 'moderate';
                    $data['fond_status'] = 'moderate';
                    $help->update($data);
                } else {
                    $help = Help::create($data);
                    $is_created = true;
                }

                if ($request->hasFile('photo')) {
                    $validator = validator::make($request->all(), [
                        'photo.*' => 'image|mimes:jpeg,png,jpg|max:1000'
                    ], [
                        'photo.*.image' => 'Неверный формат фото',
                        'photo.*.max' => 'Размер фото не должен превышать 2мб',
                        'photo.*.mimes' => 'Фото должно быть в формате: jpeg,png,jpg'
                    ]);
                    if ($validator->fails()) {
                        if($is_created){
                            $help->delete();
                        }
                        return redirect()->back()->with('error', $validator->errors()->getMessages())->withInput();
                    }
                    foreach ($request->file('photo') as $image) {
                        $filename = microtime() . $help->id . '.' . $image->getClientOriginalExtension();
                        $thumbnailImage = Image::make($image);
                        $path = '/img/help/' . $filename;
                        $thumbnailImage->save(public_path() . $path);
                        HelpImage::create(['help_id' => $help->id, 'image' => $path]);
                    }
                }
                if ($request->hasFile('doc')) {
                    $validator = validator::make($request->all(), [
                        'doc.*' => 'mimes:jpeg,png,jpg,doc,pdf,docx,xls,xlx,txt|max:3000'
                    ], [
                        'doc.*.max' => 'Размер документа не должен превышать 3мб',
                        'doc.*.mimes' => 'Документ должен быть в формате: jpeg,png,jpg,doc,pdf,docx,xls,xlx,txt'
                    ]);
                    if ($validator->fails()) {
                        if($is_created){
                            $help->delete();
                        }
                        return redirect()->back()->with('error',  $validator->errors()->getMessages());
                    }
                    foreach ($request->file('doc') as $doc) {
                        $filename = microtime() . $help->id . '.' . $doc->getClientOriginalExtension();
                        $path = '/img/help/docs/';
                        $doc->move(public_path() . $path, $filename);
                        HelpDoc::create(['help_id' => $help->id, 'path' => $path . $filename, 'original_name' => $doc->getClientOriginalName()]);
                    }
                }
                $inputs = $request->all();

                $fonds = Fond::select(['id', 'title_ru', 'logo', 'created_at', 'foundation_date', 'about_ru'])->whereHas('scenarios', function ($query) use ($inputs) {
                    $query->where('scenario_id', $inputs['who_need_help']);
                })->whereHas('baseHelpTypes', function ($query) use ($inputs) {
                    $query->where('base_help_id', $inputs['baseHelpTypes']);
                })->orWhereHas('addHelpTypes', function ($query) use ($inputs) {
                    $query->where('add_help_id', $inputs['baseHelpTypes']);
                });
                if ($inputs['region_id'] != 728) {
                    if (array_key_exists('city_id', $inputs)) {
                        if ($inputs['city_id'] != 0) {
                            $fonds = $fonds->whereHas('cities', function ($query) use ($inputs) {
                                $query->where('fond_cities.city_id', $inputs['city_id']);
                            });
                        }
                    }
                    if (array_key_exists('district_id', $inputs)) {
                        if ($inputs['district_id'] != 0) {
                            $fonds = $fonds->whereHas('districts', function ($query) use ($inputs) {
                                $query->where('fond_districts.district_id', $inputs['district_id']);
                            });
                        }
                    }
                    if (array_key_exists('region_id', $inputs)) {
                        $fonds = $fonds->whereHas('regions', function ($query) use ($inputs) {
                            $query->where('fond_regions.region_id', $inputs['region_id']);
                        });
                    }
                }

                $fonds = $fonds->with(['destinations' => function ($query) {
                    $query->select('id', 'name_ru', 'points');
                }, 'cashHelpTypes' => function ($query) {
                    $query->select('id', 'name_ru');
                }, 'cashHelpSizes' => function ($query) {
                    $query->select('id', 'name_ru');
                }])->where('status', '1')->get()->toArray();

                $cashHelpSizes = CashHelpSize::pluck('id')->toArray();
                $fondsByPoints = [];

                foreach ($fonds as $key => $fond) {
                    $fondsByPoints[$key] = $fond;
                    $fondsByPoints[$key]['points'] = 0;
                    if (array_key_exists('destinations', $inputs)) {
                        foreach ($fond['destinations'] as $destination) {
                            if (in_array($destination['id'], $inputs['destinations'])) {
                                $fondsByPoints[$key]['points'] += $destination['points'];
                            }
                        }
                    }

                    foreach ($fond['cash_help_types'] as $cashHelpType) {
                        if (in_array($cashHelpType['id'], $inputs['cashHelpTypes'])) {
                            $fondsByPoints[$key]['points'] += 5;
                        }
                    }
                    foreach ($fond['cash_help_sizes'] as $cashHelpSize) {
                        if ($inputs['cash_help_size_id'] == $cashHelpSize['id']) {
                            $fondsByPoints[$key]['points'] += array_search($cashHelpSize['id'], $cashHelpSizes) + 4;
                        }
                    }
                    if ($fond['id'] == 20) {
                        $fondsByPoints[$key]['points'] = 100;
                    }
                }
                if (count($fondsByPoints) <= 0) {
                    $fondsByPoints[0] = Fond::select(['id'])->where('id', 20)->first()->toArray();
                    $fondsByPoints[0]['points'] = 100;
                }
                $fondsids = [];
                $coincidence = 0;
                array_sort_by_column($fondsByPoints, 'points');
                foreach ($fondsByPoints as $key => $fondsByPoint) {
                    if ($fondsByPoint['points'] > 0) {
                        $coincidence = round($fondsByPoint['points'] / $fondsByPoints[0]['points'] * 100);
                    }
                    if ($coincidence < 45) {
                        continue;
                    }
                    $fondsids[] = [
                        'fond_id' => $fondsByPoint['id'],
                        'fond_status' => 'disable'
                    ];
                }
                if($request->destinations){
                    if (count($request->destinations)>0) {
                        $help->destinations()->sync($request->destinations);
                    }
                }
                if (isset($request->baseHelpTypes) && !empty($request->baseHelpTypes)) {
                    if(is_array( $request->baseHelpTypes)){
                        if (in_array(0, $request->baseHelpTypes)) {
                            if (($key = array_search(0, $request->baseHelpTypes)) !== false) {
                                unset($request->baseHelpTypes[$key]);
                            }
                        }
                        if(count($request->baseHelpTypes)>0){
                           try{
                               $help->addHelpTypes()->sync([$request->baseHelpTypes]);
                           }catch (\Exception $exception){
                               Log::info($request->baseHelpTypes);
                           }
                        }
                    }else{
                       try{
                           $help->addHelpTypes()->sync([$request->baseHelpTypes]);
                       }catch (\Exception $exception){
                           Log::info($request->baseHelpTypes);
                       }
                    }
                }
                if (isset($request->cashHelpTypes) && !empty($request->cashHelpTypes)) {
                    $help->cashHelpTypes()->sync($request->cashHelpTypes);
                }
            $help->fonds()->sync($fondsids);
            return redirect()->route('cabinet')->with(['success' => 'Ваша заявка успешно отправлена!', 'info' => 'Заявка отправлена на модерацию']);
        }
        if ($request->method() == 'GET') {
            $help = null;
            $scenarios = Scenario::select('id', 'name_ru', 'name_kz')->with(['addHelpTypes', 'destinations'])->get()->toArray();
            $baseHelpTypes = AddHelpType::all();
            $regions = Region::select('region_id', 'title_ru as text')->with('districts.cities')->limit(10)->get();
            $destinations = Destination::all();
            $cashHelpTypes = CashHelpType::all();
            $cashHelpSizes = CashHelpSize::all();
        }
        return view('frontend.fond.request_help')->with(compact('baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes', 'scenarios', 'help'));
    }

    public function fonds(Request $request)
    {
        if ($request->ajax()) {

            $fonds = Fond::where('status', true);

            if ($request->exists('destination')) {
                $destination = $request->destination;
                $fonds->whereHas('destinations', function ($query) use ($destination) {
                    $query->whereIn('destinations.id', $destination);
                });
            }

            if ($request->exists('city')) {
                $destination = $request->city;
                $fonds->whereIn('help_location_city', $destination);
            }
            if ($request->exists('regions')) {
                $destination = $request->regions;
                $fonds->whereIn('help_location_region', $destination);
            }

            if ($request->exists('cashHelpType')) {
                $cashHelpType = $request->cashHelpType;
                $fonds->whereHas('cashHelpTypes', function ($query) use ($cashHelpType) {
                    $query->whereIn('cash_help_id', $cashHelpType);
                });
            }

            if ($request->exists('cashHelpSize')) {
                $cashHelpSize = $request->cashHelpSize;
                $fonds->whereHas('cashHelpSizes', function ($query) use ($cashHelpSize) {
                    $query->whereIn('cash_help_size_id', $cashHelpSize);
                });
            }

            if ($request->exists('baseHelpTypes')) {
                $baseHelpTypes = $request->baseHelpTypes;
                $fonds->whereHas('baseHelpTypes', function ($query) use ($baseHelpTypes) {
                    $query->whereIn('base_help_id', $baseHelpTypes);
                });
            }
            if ($request->exists('bin') && $request->input('bin')!='') {
                $fonds = Fond::where('status', true);
                if($request->exists('bin') && $request->bin !=''){
                    if(is_numeric($request->bin)){
                        $fonds->where('bin','like', $request->bin.'%');
                    }else{
                        $fonds->where('title_ru','like', '%'.$request->bin.'%');
                    }

                }
            }
            $fonds = $fonds->paginate(4);
            return view('frontend.fond.fond_list')->with(compact('fonds'));
        } else {
            $fonds = Fond::where('status', true);

            if ($request->exists('destination')) {
                $destination = $request->destination;
                $fonds->whereHas('destinations', function ($query) use ($destination) {
                    $query->whereIn('destinations.id', $destination);
                });
            }

            if ($request->exists('city')) {
                $destination = $request->city;
                $fonds->whereIn('help_location_city', $destination);
            }
            if ($request->exists('regions')) {
                $destination = $request->regions;
                $fonds->whereIn('help_location_region', $destination);
            }

            if ($request->exists('cashHelpType')) {
                $cashHelpType = $request->cashHelpType;
                $fonds->whereHas('cashHelpTypes', function ($query) use ($cashHelpType) {
                    $query->whereIn('cash_help_id', $cashHelpType);
                });
            }

            if ($request->exists('cashHelpSize')) {
                $cashHelpSize = $request->cashHelpSize;
                $fonds->whereHas('cashHelpSizes', function ($query) use ($cashHelpSize) {
                    $query->whereIn('cash_help_size_id', $cashHelpSize);
                });
            }

            if ($request->exists('baseHelpTypes')) {
                $baseHelpTypes = $request->baseHelpTypes;
                $fonds->whereHas('baseHelpTypes', function ($query) use ($baseHelpTypes) {
                    $query->whereIn('base_help_id', $baseHelpTypes);
                });
            }
            if ($request->input('bin')!='') {
                $fonds = Fond::where('status', true);
                $fonds->where('bin', 'like', $request->bin . '%');
            }

            $fonds = $fonds->paginate(4);
            $cities = City::whereIn('title_ru', ['Нур-Султан', 'Алма-Ата', 'Шымкент'])->pluck('title_ru', 'city_id');
            $regions = Region::all();
            $baseHelpTypes = AddHelpType::all();
            $destionations = Destination::all();
            $cashHelpTypes = CashHelpType::all();
            $cashHelpSizes = CashHelpSize::all();
        }
        return view('frontend.fond.fonds')->with(compact('fonds', 'cities', 'regions', 'baseHelpTypes', 'destionations', 'cashHelpTypes', 'cashHelpSizes'));
    }

    public function donationToFond(Request $request)
    {
        $fond = Fond::findOrFail($request->fond_id);
        $last_donation = FondDonation::latest()->first();
        $amount = $request->amount;
        $orderId = sprintf("%06d", $last_donation->id);

        $vSign = hash("sha512", config('app.C_SHARED_KEY') .
            $orderId.";".
            $amount.
            ";KZT;".
            "atamekenim.kz;" .
            "12200005;" .
            ";" .
            $orderId.";" . // client id
            "test;" . // preview desc
            ";" . // full desc
            ";" . // email
            "https://www.google.kz;" .
            ";" . //
            ";" .
            ";" .
            ";" .
            ";");

        return view('frontend.payment')->with(compact('orderId', 'vSign', 'fond', 'amount'));
    }


    public function cloudPaymentsDonation(Request $request)
    {
        $payment = new Payment();
        $payment->fond_id = $request->fond_id;
        $payment->anonim = $request->anonim ? 1 : 0;
        $payment->fio = $request->fio;
        $payment->amount = $request->amount;
        $payment->save();
        return 'ok';
    }

    private function getPersonStatus(string $iin)
    {
//        if($iin == '980101351561'){
//            $iins = ['820803450538', '820803450535', '820803450537'];
//            $iin = $iins[array_rand($iins)];
//        }
        try{
            $client = new \GuzzleHttp\Client();
            $client = $client->get('http://127.0.0.1:8900/personStatus/'.$iin);
            $statuses = json_decode($client->getBody()->getContents());
            if($statuses){
                return json_encode($statuses->statuses);
            }else{
                return json_encode(['valueRu' => 'Данные не найдены', 'valueKz'=> '']);
            }
        }catch (GuzzleException $exception){
            return json_encode(['valueRu' => 'Данные не найдены', 'valueKz'=> '']);
        }
    }

}
