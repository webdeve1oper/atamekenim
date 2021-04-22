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
use App\Http\Controllers\Controller;
use App\Region;
use App\Scenario;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FondController extends Controller
{

    //
    public function fond($id)
    {
        $fond = Fond::where('id', $id)->with('projects')->with('helps')->first();
        $baseHelpTypes = AddHelpType::all();
        $regions = Region::select('region_id', 'title_ru as text')->where('country_id', 1)->with('districts')->get();
        $destinations = Destination::all();
        $cashHelpTypes = CashHelpType::all();
        $cashHelpSizes = CashHelpSize::all();
        $relatedHelpIds = $fond->baseHelpTypes->pluck('id')->toArray();
        $relatedFonds = Fond::select('logo', 'title_ru', 'title_kz')->where('id', '!=', $fond->id)->whereHas('baseHelpTypes', function ($query) use ($relatedHelpIds) {
            $query->whereIn('id', $relatedHelpIds);
        })->get();

        $last_donation = FondDonation::find(2);
        $amount = 100;
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

        return view('frontend.fond.fond')->with(compact('fond', 'baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes', 'relatedFonds', 'vSign', 'orderId'));
    }

    public function request_help(Request $request)
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
            if($request->hasFile('photo')){
                foreach($request->file('photo') as $image)
                {
                    $image->resize(300, 200);
                    $name = $image->getClientOriginalName();
                    $image->move(public_path().'/images/', $name);
                    $data[] = $name;
                }
            }
            $request['user_id'] = Auth::user()->id;
            $help = Help::create($request->all());
            $fonds = Fond::pluck('id');
            if (isset($request->destinations) && !empty($request->destinations)) {
                $help->destinations()->attach($request->destinations);
            }
            if (isset($request->baseHelpTypes) && !empty($request->baseHelpTypes)) {
                $help->addHelpTypes()->attach($request->baseHelpTypes);
            }
            if (isset($request->cashHelpTypes) && !empty($request->cashHelpTypes)) {
                $help->cashHelpTypes()->attach($request->cashHelpTypes);
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

            if ($request->exists('bin')) {
                $fonds->where('bin', 'like', $request->bin . '%');
            }

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

            if ($request->exists('destinations_attribute')) {
                $destinations_attribute = $request->destinations_attribute;
                $fonds->whereHas('destinations_attribute', function ($query) use ($destinations_attribute) {
                    $query->whereIn('destinations_attribute.id', $destinations_attribute);
                });
            }

            if ($request->exists('baseHelpTypes')) {
                $baseHelpTypes = $request->baseHelpTypes;
                $fonds->whereHas('baseHelpTypes', function ($query) use ($baseHelpTypes) {
                    $query->whereIn('base_help_types.id', $baseHelpTypes);
                });
            }
            $fonds = $fonds->paginate(4);

            return view('frontend.fond.fond_list')->with(compact('fonds'));
        } else {
            $fonds = Fond::paginate(4);
            $cities = City::whereIn('title_ru', ['Нур-Султан', 'Алма-Ата', 'Шымкент'])->pluck('title_ru', 'city_id');
            $regions = Region::all();
            $baseHelpTypes = AddHelpType::all();
            $destionations = Destination::all();
            $cashHelpTypes = CashHelpType::all();
            $cashHelpSizes = CashHelpSize::all();
        }
        return view('frontend.fond.fonds')->with(compact('fonds', 'cities', 'regions', 'baseHelpTypes', 'destionations', 'cashHelpTypes', 'cashHelpSizes'));
    }

    public function donationToFond($id)
    {
        $last_donation = FondDonation::find(1);
        $amount = 10;
        $orderId = sprintf("%06d", $last_donation->id);

        $vSign = hash("sha512", config('app.C_SHARED_KEY') .
            $orderId.";".$amount.";KZT;" .
            "ECOMMTESTJYSAN;" .
            "12200005;" .
            $orderId.";" . // client id
            "Test;" . // preview desc
            ";" . // full desc
            ";" . //client name
            ";" . // email
            "https://atamekenim.kz;" .
            ";" .
            ";");



//        $client = $client->get('https://jpay.jysanbank.kz/ecom/api', ['query'=>$params]);
        dd($vSign);

    }
}
