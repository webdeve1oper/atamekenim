<?php

namespace App\Http\Controllers\Frontend;

use App\AddHelpType;
use App\BaseHelpType;
use App\CashHelpSize;
use App\CashHelpType;
use App\City;
use App\Country;
use App\Destination;
use App\DestinationAttribute;
use App\Fond;
use App\FondDonation;
use App\Help;
use App\HelpDoc;
use App\HelpImage;
use App\Http\Controllers\Controller;
use App\Payment;
use App\Region;
use App\Scenario;
use AvtoDev\CloudPayments\Config;
use AvtoDev\CloudPayments\Client;
use AvtoDev\CloudPayments\Requests\Subscriptions\SubscriptionsCreateRequestBuilder;
use GuzzleHttp\Client as GuzzleClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class FondController extends Controller
{

    //
    public function fond($id)
    {
//        $client = new Config(config('app.PUBLIC_KEY'), config('app.PRIVATE_KEY'));
//        $request = SubscriptionsCreateRequestBuilder::buildRequest();
        $fond = Fond::where('id', $id)->with('projects')->with('helps')->first();
        $baseHelpTypes = AddHelpType::all();
        $regions = Region::select('region_id', 'title_ru as text')->where('country_id', 1)->with('districts')->get();
        $destinations = Destination::all();
        $cashHelpTypes = CashHelpType::all();
        $cashHelpSizes = CashHelpSize::all();
        $relatedHelpIds = $fond->baseHelpTypes->pluck('id')->toArray();
        $relatedFonds = Fond::select('id','logo', 'title_ru', 'title_kz')->where('id', '!=', $fond->id)->whereHas('baseHelpTypes', function ($query) use ($relatedHelpIds) {
            $query->whereIn('id', $relatedHelpIds);
        })->get();

        return view('frontend.fond.fond')->with(compact('fond', 'baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes', 'relatedFonds'));
    }

    public function requestHelp(Request $request)
    {
//        if ($request->ajax()) {
//            $relatedHelpIds = $request->destinations;
//            $scenario_id = $request->who_need_help;
//            $relatedFonds = Fond::whereHas('scenarios', function($query) use ($scenario_id){
//                $query->where('scenario_id', $scenario_id);
//            })->get();
//            return view('frontend.fond.request_help_fonds')->with(compact('relatedFonds'));
//        }
        if ($request->method() == 'POST') {
            $request['user_id'] = Auth::user()->id;
            $help = Help::create($request->all());
            if($request->hasFile('photo')){
//                $this->validate($request, [
//                    'photo.*' => 'image|mimes:jpeg,png,jpg|max:2048'
//                ]);
                foreach($request->file('photo') as $image)
                {
                    $filename = microtime().$help->id.'.'.$image->getClientOriginalExtension();
                    $thumbnailImage = Image::make($image);
                    $path = '/img/help/'.$filename;
                    $thumbnailImage->resize(700, null)->save(public_path().$path);
                    HelpImage::create(['help_id'=>$help->id, 'image'=>$path]);
                }
            }
            if($request->hasFile('doc')){
//                $this->validate($request, [
//                    'doc.*' => 'mimes:jpeg,png,jpg,doc,pdf,docx,xls,xlx,txt|max:5000'
//                ]);
                foreach($request->file('doc') as $doc)
                {
                    $filename = microtime().$help->id.'.'.$doc->getClientOriginalExtension();
                    $path = '/img/help/docs/';
                    $doc->move(public_path().$path, $filename);
                    HelpDoc::create(['help_id'=>$help->id, 'path'=>$path.$filename, 'original_name'=>$doc->getClientOriginalName()]);
                }
            }
            $fonds = Fond::pluck('id');
            if (isset($request->destinations) && !empty($request->destinations)) {
                $help->destinations()->sync($request->destinations);
            }
            if (isset($request->baseHelpTypes) && !empty($request->baseHelpTypes)) {
                $help->addHelpTypes()->sync($request->baseHelpTypes);
            }
            if (isset($request->cashHelpTypes) && !empty($request->cashHelpTypes)) {
                $help->cashHelpTypes()->sync($request->cashHelpTypes);
            }
            $help->fonds()->attach($fonds);
            return redirect()->route('cabinet')->with(['success' => 'Ваша заявка усешно отправлена!', 'info' => 'Заявка отправена на модерацию']);
        }
        if ($request->method() == 'GET') {
            $scenarios = Scenario::select('id', 'name_ru', 'name_kz')->with(['addHelpTypes', 'destinations'])->get()->toArray();
            $baseHelpTypes = AddHelpType::all();
            $regions = Region::select('region_id', 'title_ru as text')->with('districts.cities')->limit(10)->get();
            $destinations = Destination::all();
            $cashHelpTypes = CashHelpType::all();
            $cashHelpSizes = CashHelpSize::all();
        }
        return view('frontend.fond.request_help')->with(compact('baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes', 'scenarios'));
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
                $fonds->where('bin', 'like', $request->bin . '%');
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

}
