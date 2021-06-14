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
                $helps->where('body', 'like','%'.$search.'%');
                $helps->orWhereHas('user', function($query) use ($search){
                    $query->where('first_name', $search);
                });
                $helps->paginate(5);

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
                $helps->whereHas('baseHelpTypes', function ($query) use ($baseHelpTypes) {
                    $query->whereIn('base_help_id', $baseHelpTypes);
                });
            }
            $helps->paginate(5);

            return view('frontend.help.help_list', compact('helps'));
        }else{
            $helps = Help::with('addHelpTypes')->paginate(5);
            $cities = City::whereIn('title_ru', ['Нур-Султан', 'Алма-Ата', 'Шымкент'])->pluck('title_ru','city_id');
            $regions = Region::where('country_id', 1)->pluck('title_ru', 'region_id');
            $baseHelpTypes = BaseHelpType::all();
            $destionations = Destination::all();

            return view('frontend.help.helps')->with(compact('helps', 'regions', 'cities','baseHelpTypes','destionations'));
        }
    }
}
