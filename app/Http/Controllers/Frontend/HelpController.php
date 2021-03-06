<?php

namespace App\Http\Controllers\Frontend;

use App\BaseHelpType;
use App\City;
use App\Destination;
use App\Fond;
use App\Help;
use App\Region;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function helps(Request $request){
        if ($request->ajax()) {
            $helps = Help::query();

            if ($request->input('search') != '') {
                $search = $request->search;
                $helps = $helps->where('body', 'like','%'.$search.'%');
                $helps = $helps->orWhereHas('user', function($query) use ($search){
                    $query->where('first_name', $search);
                });
                $helps = $helps->orWhereHas('user', function($query) use ($search){
                    $query->where('last_name', $search);
                });
                $helps = $helps->orWhereHas('user', function($query) use ($search){
                    $query->where('patron', $search);
                });
                $helps = $helps->where('admin_status', 'finished')->whereIn('fond_status', ['process','wait'])->paginate(5);

                return view('frontend.help.help_list', compact('helps'));
            }
            if ($request->exists('destination')) {
                $destination = $request->destination;
                $helps->whereHas('destinations', function ($query) use ($destination) {
                    $query->whereIn('destinations.id', $destination);
                });
            }

            if ($request->exists('cashHelpType')) {
                $cashHelpType = $request->cashHelpType;
                $helps->whereHas('cashHelpTypes', function ($query) use ($cashHelpType) {
                    $query->whereIn('cash_help_id', $cashHelpType);
                });
            }

            if ($request->exists('cashHelpSize')) {
                $cashHelpSize = $request->cashHelpSize;
                $helps->whereHas('cashHelpSizes', function ($query) use ($cashHelpSize) {
                    $query->whereIn('cash_help_size_id', $cashHelpSize);
                });
            }

            if ($request->exists('baseHelpTypes')) {
                $baseHelpTypes = $request->baseHelpTypes;
                $helps->whereHas('addHelpTypes', function ($query) use ($baseHelpTypes) {
                    $query->whereIn('add_help_id', $baseHelpTypes);
                });
            }
            if ($request->exists('regions')) {
                $regions = $request->regions;
                $helps->whereHas('region', function ($query) use ($regions) {
                    $query->whereIn('region_id', $regions);
                });
            }
            $helps = $helps->where('admin_status', 'finished')->whereIn('fond_status', ['process','wait'])->paginate(5);

            return view('frontend.help.help_list', compact('helps'));
        }else{
            $helps = Help::with('addHelpTypes')->where('admin_status', 'finished')->whereIn('fond_status', ['process','wait'])->paginate(5);
            $cities = City::whereIn('title_ru', ['??????-????????????', '????????-??????', '??????????????'])->pluck('title_ru','city_id');
            $regions = Region::where('country_id', 1)->pluck('title_ru', 'region_id');
            $baseHelpTypes = BaseHelpType::all();
            $destionations = Destination::all();

            return view('frontend.help.helps')->with(compact('helps', 'regions', 'cities','baseHelpTypes','destionations'));
        }
    }
}
