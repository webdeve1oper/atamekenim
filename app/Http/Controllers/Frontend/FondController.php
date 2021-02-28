<?php

namespace App\Http\Controllers\Frontend;

use App\AddHelpType;
use App\BaseHelpType;
use App\City;
use App\Country;
use App\Destination;
use App\DestinationAttribute;
use App\Fond;
use App\Http\Controllers\Controller;
use App\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FondController extends Controller
{
    //
    public function fond($id){
        $fond = Fond::where('id',$id)->with('projects')->with('helps')->first();
        $baseHelpTypes = BaseHelpType::select('name_ru as text', 'id')->with('addHelpTypes')->get();
        $regions = Region::select('region_id', 'title_ru as text')->where('country_id', 1)->with('cities')->get();

        return view('frontend.fond.fond')->with(compact('fond', 'baseHelpTypes', 'regions'));
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
            }elseif($request->exists('region')){
                $destination = $request->region;
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
            $baseHelpTypes = BaseHelpType::all();
            $addHelpTypes = AddHelpType::all();
            $destionations = Destination::all();
            $destionationsAttributes = DestinationAttribute::all();
        }


        return view('frontend.fond.fonds')->with(compact('fonds', 'cities', 'regions', 'baseHelpTypes', 'addHelpTypes', 'destionations', 'destionationsAttributes'));

    }
}
