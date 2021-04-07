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
use Illuminate\Support\Facades\Validator;

class FondController extends Controller
{
    //
    public function fond($id){
        $fond = Fond::where('id',$id)->with('projects')->with('helps')->first();
        $baseHelpTypes = AddHelpType::all();
        $regions = Region::select('region_id', 'title_ru as text')->where('country_id', 1)->with('districts')->get();
        $destinations = Destination::all();
        $cashHelpTypes = CashHelpType::all();
        $cashHelpSizes = CashHelpSize::all();
        $relatedHelpIds = $fond->baseHelpTypes->pluck('id')->toArray();
        $relatedFonds = Fond::select('logo', 'title')->where('id', '!=',$fond->id)->whereHas('baseHelpTypes', function($query) use ($relatedHelpIds){
            $query->whereIn('id', $relatedHelpIds);
        })->get();

        return view('frontend.fond.fond')->with(compact('fond', 'baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes', 'relatedFonds'));
    }

    public function request_help(Request $request){
        if ($request->ajax()) {
//            $relatedFonds = Fond::select('logo', 'title')->where('id', '!=',$fond->id)->whereHas('baseHelpTypes', function($query) use ($relatedHelpIds){
//                $query->whereIn('base_help_id', $relatedHelpIds);
//            })->get();
            return view('frontend.fond.request_help_fonds')->with();
        }
        $scenarios = Scenario::select('id','name_ru', 'name_kz')->with(['addHelpTypes', 'destinations'])->get();
        $baseHelpTypes = AddHelpType::all();
        $regions = Region::select('region_id', 'title_ru as text')->with('districts.cities')->limit(10)->get();
        $destinations = Destination::all();
        $cashHelpTypes = CashHelpType::all();
        $cashHelpSizes = CashHelpSize::all();


        return view('frontend.fond.request_help')->with(compact( 'baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes', 'scenarios'));
    }

    public function fonds(Request $request){
        if ($request->ajax()) {

            $fonds = Fond::where('status', true);

            if($request->exists('bin')){
                $fonds->where('bin','like', $request->bin.'%');
            }

            if($request->exists('destination')){
                $destination = $request->destination;
                $fonds->whereHas('destinations', function($query) use ($destination){
                    $query->whereIn('destinations.id', $destination);
                });
            }

            if($request->exists('city')){
                $destination = $request->city;
                $fonds->whereIn('help_location_city', $destination);
            }
            if($request->exists('regions')){
                $destination = $request->regions;
                $fonds->whereIn('help_location_region', $destination);
            }

            if($request->exists('destinations_attribute')){
                $destinations_attribute = $request->destinations_attribute;
                $fonds->whereHas('destinations_attribute', function($query) use ($destinations_attribute){
                    $query->whereIn('destinations_attribute.id', $destinations_attribute);
                });
            }

            if($request->exists('baseHelpTypes')){
                $baseHelpTypes = $request->baseHelpTypes;
                $fonds->whereHas('baseHelpTypes', function($query) use ($baseHelpTypes){
                    $query->whereIn('base_help_types.id', $baseHelpTypes);
                });
            }
            $fonds = $fonds->paginate(4);

            return view('frontend.fond.fond_list')->with(compact('fonds'));
        }else{
            $fonds = Fond::paginate(4);
            $cities = City::whereIn('title_ru', ['Нур-Султан', 'Алма-Ата', 'Шымкент'])->pluck('title_ru','city_id');
            $regions = Region::where('country_id', 1)->pluck('title_ru', 'region_id');
            $baseHelpTypes = AddHelpType::all();
            $destionations = Destination::all();
        }
        return view('frontend.fond.fonds')->with(compact('fonds', 'cities', 'regions', 'baseHelpTypes', 'destionations'));
    }

    public function donationToFond($id)
    {
        $last_donation = FondDonation::latest()->first();

        $client = Client::get('https://jpay.jysanbank.kz/ecom/api');

        $vSign = hash("sha512",config('app.C_SHARED_KEY')
            .$_POST["order"].";"
            .$_POST["mpi_order"].";"
            .$_POST["amount"].";398;"
            .$_POST["res_code"].";"
            .$_POST["rc"].";"
            .$_POST["rrn"].";" );
    }
}
