<?php

namespace App\Http\Controllers\Frontend;

use App\AddHelpType;
use App\BaseHelpType;
use App\City;
use App\Destination;
use App\Fond;
use App\Help;
use App\Http\Controllers\Controller;
use App\News;
use App\Region;
use App\Review;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function index(Request $request){


        if ($request->ajax()) {

            $fonds = Fond::where('status', true);

            if($request->exists('bin') && $request->bin !=''){
                $fonds->where('bin','like', $request->bin.'%');
            }

            if($request->exists('destination') && $request->input('destination')[0]!='all'){
                $destination = $request->destination;
                $fonds->whereHas('destinations', function($query) use ($destination){
                    $query->whereIn('destinations.id', $destination);
                });
            }

            if($request->exists('city') && $request->input('city')[0]!='all'){
                $cities = $request->city;
                $fonds->whereIn('help_location_city', $cities);
            }

            if($request->exists('baseHelpTypes') && $request->input('baseHelpTypes')[0]!='all'){
                $baseHelpTypes = $request->baseHelpTypes;
                $fonds->whereHas('baseHelpTypes', function($query) use ($baseHelpTypes){
                    $query->whereIn('base_help_types.id', $baseHelpTypes);
                });
            }

            $fonds = $fonds->paginate(5);

            return view('frontend.home_fond_list')->with(compact('fonds'));
        }else{
            $fonds = Fond::where('status', true)->paginate(5);
            $destionations = Destination::all();
            $cities = City::whereRegionId(720)->pluck('title_ru', 'city_id');
            $newFonds = Fond::where('status', true)->orderBy('created_at')->paginate(6);
            $helpsCount = Help::count();
            $helps = Help::whereStatus('finished')->paginate(4);
            $newHelps = Help::whereStatus('wait')->paginate(4);
            $baseHelpTypes = AddHelpType::all();
            $news = News::orderBy('public_date', 'desc')->limit(10)->get();
            return view('frontend.home')->with(compact('fonds', 'news', 'newFonds','destionations','cities','baseHelpTypes', 'helps', 'helpsCount', 'newHelps'));
        }
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
        if ($request->ajax()) {
            $helps = Fond::query();

            $helps->paginate(5);

            return view('project_list', compact('helps'));
        }else{
            $helps = Help::with('baseHelpTypes')->with('addHelpTypes')->paginate(5);
            $cities = City::whereIn('title_ru', ['Нур-Султан', 'Алма-Ата', 'Шымкент'])->pluck('title_ru','city_id');
            $regions = Region::where('country_id', 1)->pluck('title_ru', 'region_id');
            $baseHelpTypes = BaseHelpType::all();
            $destionations = Destination::all();

            return view('frontend.help.helps')->with(compact('helps', 'regions', 'cities','baseHelpTypes','destionations'));
        }
    }

    public function help(){
        return redirect()->route('dev');
    }

    public function reviews(){
        return view('frontend.develope');
    }

    public function about(){
        return view('frontend.develope');
    }

    public function contacts(){
        return view('frontend.develope');
    }

    public function qa(){
        return view('frontend.develope');
    }
}
