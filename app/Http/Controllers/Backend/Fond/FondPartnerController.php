<?php

namespace App\Http\Controllers\Backend\Fond;

use App\AddHelpType;
use App\BaseHelpType;
use App\CashHelpSize;
use App\CashHelpType;
use App\City;
use App\Destination;
use App\DestinationAttribute;
use App\FinishedHelp;
use App\FinishedHelpHelper;
use App\Fond;
use App\FondImage;
use App\FondOffice;
use App\FondRequisite;
use App\Help;
use App\History;
use App\Partner;
use App\Project;
use App\ProjectCompanies;
use App\ProjectHumans;
use App\ProjectPartners;
use App\ProjectSponsors;
use App\Region;
use App\Scenario;
use Carbon\Carbon;
use Faker\Provider\Company;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FondPartnerController extends Controller
{
    public function partners(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(),
                [
                    'title' => 'required|min:3',
                    'image' => 'mimes:jpeg,jpg,png|max:1000',
                    'orders' => 'required'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $request->all();

            if ($request->file('image')) {
                $originalImage = $request->file('image');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = '/img/partners/' . Auth::user()->id;
                File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                $path = time() . '.' . $originalImage->getClientOriginalExtension();
                $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                $data['image'] = $thumbnailPath . '/' . $path;
                $data['fond_id'] = Auth::user()->id;
                $data['orders'] = count(Auth::user()->partners) + 1;
                Partner::create($data);
                return redirect()->back();
            } else {
                return redirect()->back();
            }

        } elseif ($request->method() == 'GET') {
            $partners = Auth::user()->partners()->orderBy('orders','asc')->get();
            return view('backend.fond_cabinet.partners.index')->with(compact('partners'));
        }
    }

    public function updatePartner(Request $request){
        $partner = Partner::find($request->partner_id);
        $partner->orders = $request->get('orders');
        $partner->save();
        return redirect()->back()->with('success','Порядок обновлен!');
    }

    public function deletePartner(Request $request)
    {
        $partner = Partner::find($request->id);
        if (File::exists($partner->image)) {
            File::delete($partner->image);
        }
        $partner->delete();
        return redirect()->back();
    }
}
