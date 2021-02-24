<?php

namespace App\Http\Controllers\Frontend;

use App\AddHelpType;
use App\BaseHelpType;
use App\City;
use App\Country;
use App\Fond;
use App\Http\Controllers\Controller;
use App\Region;
use Illuminate\Http\Request;

class FondController extends Controller
{
    //
    public function fond($id){
        $fond = Fond::where('id',$id)->with('projects')->with('helps')->first();
        $baseHelpTypes = BaseHelpType::select('name_ru as text', 'id')->with('addHelpTypes')->get();
        $regions = Region::select('region_id', 'title_ru as text')->where('country_id', 4)->with('cities')->get();

//        $addHelpTypes = AddHelpType::all();

        return view('frontend.fond.fond')->with(compact('fond', 'baseHelpTypes', 'regions'));
    }

    public function fonds(){
        $fonds = Fond::paginate(2);
        $cities = City::whereIn('title_ru', ['Нур-Султан', 'Алма-Ата', 'Шымкент'])->pluck('title_ru','city_id');
        $regions = Region::where('country_id', 4)->pluck('title_ru', 'region_id');
        $baseHelpTypes = BaseHelpType::all();
        $addHelpTypes = AddHelpType::all();

        return view('frontend.fond.fonds')->with(compact('fonds', 'cities', 'regions', 'baseHelpTypes', 'addHelpTypes'));

    }
}
