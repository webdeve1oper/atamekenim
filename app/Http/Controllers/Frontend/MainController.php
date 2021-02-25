<?php

namespace App\Http\Controllers\Frontend;

use App\BaseHelpType;
use App\City;
use App\Fond;
use App\Help;
use App\Http\Controllers\Controller;
use App\News;
use App\Region;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function index(){
        $fonds = Fond::all();
        $newFonds = Fond::orderBy('created_at')->get();
        $news = News::orderBy('public_date', 'desc')->limit(10)->get();
        return view('frontend.home')->with(compact('fonds', 'news', 'newFonds'));
    }



    public function new($slug){
        $new = News::whereSlug($slug)->first();

        return view('frontend.new')->with(compact('new'));
    }

    public function news(){
        $news = News::all();

        return view('frontend.news')->with(compact('news'));
    }

    public function helps(Request $request){
        $helps = Help::with('baseHelpTypes')->with('addHelpTypes')->paginate(1);
        $cities = City::whereIn('title_ru', ['Нур-Султан', 'Алма-Ата', 'Шымкент'])->pluck('title_ru','city_id');
        $regions = Region::where('country_id', 4)->pluck('title_ru', 'region_id');
        $baseHelpTypes = BaseHelpType::all();

        return view('frontend.help.helps')->with(compact('helps', 'regions', 'cities','baseHelpTypes'));
    }
}
