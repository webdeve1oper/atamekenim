<?php

namespace App\Http\Controllers\Backend;

use App\AddHelpType;
use App\BaseHelpType;
use App\CashHelpSize;
use App\CashHelpType;
use App\City;
use App\Destination;
use App\DestinationAttribute;
use App\Fond;
use App\FondImage;
use App\Help;
use App\Partner;
use App\Project;
use App\Region;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FondController extends Controller
{
    //
    public function index()
    {
        $fond = Fond::find(Auth::user()->id);

        return view('backend.fond_cabinet.index')->with(compact('fond'));
    }

    public function start_help($id)
    {
        if (Auth::user()->helps->contains($id)) {
            $help = Help::find($id);
            $help->status = 'process';
            $help->date_fond_start = Carbon::today();
            if (DB::table('help_fond')->whereHelpId($id)->whereFondStatus('enable')->first()) {
                return redirect()->back()->with('error', 'Заявка уже принята другим фондом');
            }
            DB::table('help_fond')->update(['fond_status' => 'enable']);

            $help->save();
            return redirect()->back()->with('success', 'Успех');
        } else {
            return redirect()->back()->with('error', 'Заявка уже принята');
        }
    }

    public function finish_help($id)
    {
        if (Auth::user()->helps->contains($id)) {
            $help = Help::find($id);
            $help->status = 'finished';
            $help->date_fond_finish = Carbon::today();
            $help->save();
            return redirect()->back()->with('success', 'Успех');
        } else {
            return redirect()->back()->with('error', 'Заявка уже принята');
        }
    }


    // edit Fund
    public function edit()
    {
        $baseHelpTypes = AddHelpType::all()->toArray();
        $regions = Region::select('region_id', 'title_ru as text')->where('country_id', 1)->with('districts')->get();
        $destinations = Destination::all();
        $cashHelpTypes = CashHelpType::all();
        $cashHelpSizes = CashHelpSize::all();

        return view('backend.fond_cabinet.edit')->with(compact('baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes'));
    }

    public function projects(Request $request)
    {
        $projects = Project::whereFondId(Auth::user()->id)->get();
        return view('backend.fond_cabinet.projects.projects')->with(compact('projects'));
    }

    public function gallery(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(),
                [
                    'title' => 'required|min:3',
                    'image' => 'mimes:jpeg,jpg,png|max:10000',
                    'orders'=>'required'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $request->all();

            if ($request->file('image')) {
                $originalImage = $request->file('image');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath =  '/img/partners/'.Auth::user()->id;
                File::isDirectory(public_path() .$thumbnailPath) or File::makeDirectory(public_path() .$thumbnailPath, 0777, true, true);
                $path = time() . '.' . $originalImage->getClientOriginalExtension();
                $thumbnailImage->save(public_path() .$thumbnailPath .'/'. $path);
                $data['image'] = $thumbnailPath . '/'.$path;
                $data['fond_id'] = Auth::user()->id;
                FondImage::create($data);
                return redirect()->back();
            } else {
                return redirect()->back();
            }

        } elseif ($request->method() == 'GET') {
            $gallery = Auth::user()->images;
            return view('backend.fond_cabinet.gallery.index')->with(compact('gallery'));
        }
    }

    public function delete_gallery(Request $request){
        $partner = FondImage::find($request->id);
        if(File::exists($partner->image)) {
            File::delete($partner->image);
        }
        $partner->delete();
        return redirect()->back();
    }

    public function partners(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(),
                [
                    'title' => 'required|min:3',
                    'image' => 'mimes:jpeg,jpg,png|max:10000',
                    'orders'=>'required'
                ]
            );

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = $request->all();

            if ($request->file('image')) {
                $originalImage = $request->file('image');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath =  '/img/partners/'.Auth::user()->id;
                File::isDirectory(public_path() .$thumbnailPath) or File::makeDirectory(public_path() .$thumbnailPath, 0777, true, true);
                $path = time() . '.' . $originalImage->getClientOriginalExtension();
                $thumbnailImage->save(public_path() .$thumbnailPath .'/'. $path);
                $data['image'] = $thumbnailPath . '/'.$path;
                $data['fond_id'] = Auth::user()->id;
                Partner::create($data);
                return redirect()->back();
            } else {
                return redirect()->back();
            }

        } elseif ($request->method() == 'GET') {
            $partners = Auth::user()->partners;
            return view('backend.fond_cabinet.partners.index')->with(compact('partners'));
        }
    }

    public function delete_partner(Request $request){
        $partner = Partner::find($request->id);
        if(File::exists($partner->image)) {
            File::delete($partner->image);
        }
        $partner->delete();
        return redirect()->back();
    }


    public function create_project(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(),
                [
                    'title' => 'required|min:3',
                    'image' => 'mimes:jpeg,jpg,png|max:10000',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $socials = [];
            foreach ($request->socials as $social) {
                array_push($socials, ['link' => $social]);
            }
            $data['social'] = json_encode($socials, JSON_UNESCAPED_UNICODE);
            $fond = Fond::find(Auth::user()->id);
            $data = $request->all();
            $data['fond_id'] = $fond->id;
            $project = Project::create($data);
            $project->fond()->associate($fond);
            $project->baseHelpTypes()->sync($request->base_help_types);
        } elseif ($request->method() == 'GET') {
            $baseHelpTypes = BaseHelpType::with('addHelpTypes')->get()->toArray();
            $regions = Region::all();
            $cities = City::all();
            return view('backend.fond_cabinet.projects.create_project')->with(compact('baseHelpTypes', 'regions', 'cities'));
        }
    }


    public function update(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(),
                [
                    'title' => 'required|min:3',
                    'image' => 'mimes:jpeg,jpg,png|max:10000',
                    'requisites' => 'required'
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $requisites = [];
            foreach ($request->requisites as $requisite) {
                array_push($requisites, ['body' => $requisite]);
            }

            $offices = [];
            foreach ($request->offices as $requisite) {
                array_push($offices, ['body' => $requisite]);
            }
            $socials = [];
            foreach ($request->socials as $key=> $social) {
                array_push($socials, ['name'=>$key,'link' => $social]);
            }

            $affilates = [];
            foreach ($request->affilates as $requisite) {
                array_push($affilates, ['body' => $requisite]);
            }

            $data = $request->all();
            $data['requisites'] = json_encode($requisites, JSON_UNESCAPED_UNICODE);
            $data['offices'] = json_encode($offices, JSON_UNESCAPED_UNICODE);
            $data['affilates'] = json_encode($affilates, JSON_UNESCAPED_UNICODE);
            $data['social'] = json_encode($socials, JSON_UNESCAPED_UNICODE);
            unset($data['bin']);
            $fond = Fond::find(Auth::user()->id);

            if ($request->file('logo')) {
                $originalImage = $request->file('logo');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = public_path() . '/img/fonds/';
                $path = time() . '.' . $originalImage->getClientOriginalExtension();
                $thumbnailImage->save($thumbnailPath . $path);
                $data['logo'] = '/img/fonds/' . $path;
            } else {
                unset($data['logo']);
            }

            $fond->baseHelpTypes()->sync($request->base_help_types);
            $fond->regions()->sync($request->regions);
//            $fond->cities()->sync($request->cities);
            $fond->addHelpTypes()->sync($request->add_help_types);
            $fond->destinations()->sync($request->destinations);
            $fond->cashHelpTypes()->sync($request->cashHelpTypes);

            $fond->update($data);
            return redirect()->back();


        } else {
            return redirect()->back();
        }
    }
}
