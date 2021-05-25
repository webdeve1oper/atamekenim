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

    public function startHelp($id)
    {
//        if (Auth::user()->helps->contains($id)) {
            $help = Help::find($id);
            $help->fond_status = 'process';
            $help->date_fond_start = Carbon::today();
//            if (DB::table('help_fond')->whereHelpId($id)->whereFondStatus('enable')->first()) { // надо сделать
//                return redirect()->back()->with('error', 'Заявка уже принята другим фондом'); // надо сделать
//            }
//            DB::table('help_fond')->whereFondId(Auth::user()->id)->update(['fond_status' => 'enable']); // надо сделать
            $help->save();
            return redirect()->back()->with('success', 'Успех');
//        } else {
//            return redirect()->back()->with('error', 'Заявка уже принята');
//        }
    }

    public function finishHelp($id)
    {
//        if (Auth::user()->helps->contains($id)) {
            $help = Help::find($id);
            $help->fond_status = 'finished';
            $help->date_fond_finish = Carbon::today();
            $help->save();
            return redirect()->back()->with('success', 'Благодарим Вашу организацию за оказанную помощь заявителю по обращению ID'.getHelpId($help->id).'!');
//        } else {
//            return redirect()->back()->with('error', 'Заявка уже принята');
//        }
    }

    public function cancelHelp(Request $request)
    {
//        if (Auth::user()->helps->contains($id)) {
        if(strlen($request->desc)>0){
            $help = Help::find($request->help_id);
            $help->fond_status = 'cancel';
            $help->date_fond_finish = Carbon::today();
            $history = new History();
            $history->desc = $request->desc;
            $history->fond_id = Auth::user()->id;
            $history->help_id = $help->id;
            $history->status = 'cancel';
            $history->save();
            $help->save();
            return redirect()->back()->with('error', 'Очень жаль, что обращение ID'.getHelpId($help->id).' отклонено.');
        }else{
            return redirect()->back()->with('error', 'Заполните пожалуйста причину отклонения!');
        }

//        } else {
//            return redirect()->back()->with('error', 'Заявка уже принята');
//        }
    }


    // edit Fund
    public function edit()
    {
        $regions = Region::select('region_id', 'title_ru as text')->where('country_id', 1)->with('districts')->get();

        return view('backend.fond_cabinet.edit')->with(compact('regions'));
    }


    public function editActivity(Request $request)
    {
        if($request->method() == 'POST'){
            $fond = Fond::find(Auth::user()->id);
            $fond->baseHelpTypes()->sync($request->base_help_types);
            $fond->regions()->sync($request->regions);
            $fond->addHelpTypes()->sync($request->add_help_types);
            $fond->destinations()->sync($request->destinations);
            $fond->cashHelpTypes()->sync($request->cashHelpTypes);
            $fond->scenarios()->sync($request->scenario_id);
            return redirect()->back()->with(['success' => 'Информация успешно обновлена']);
        }else{
            $baseHelpTypes = AddHelpType::all()->toArray();
            $regions = Region::select('region_id', 'title_ru as text')->where('country_id', 1)->with('districts')->get();
            $destinations = Destination::all();
            $scenarios = Scenario::all();
            $cashHelpTypes = CashHelpType::all();
            $cashHelpSizes = CashHelpSize::all();
        }

        return view('backend.fond_cabinet.fond_target')->with(compact('baseHelpTypes', 'scenarios', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes'));
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

    public function deleteGallery(Request $request)
    {
        $partner = FondImage::find($request->id);
        if (File::exists($partner->image)) {
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

    public function deletePartner(Request $request)
    {
        $partner = Partner::find($request->id);
        if (File::exists($partner->image)) {
            File::delete($partner->image);
        }
        $partner->delete();
        return redirect()->back();
    }


    public function createProject(Request $request)
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
//            $socials = [];
//            foreach ($request->socials as $social) {
//                array_push($socials, ['link' => $social]);
//            }
//            $data['social'] = json_encode($socials, JSON_UNESCAPED_UNICODE);
            $fond = Fond::find(Auth::user()->id);
            $data = $request->all();
            $data['fond_id'] = $fond->id;
            $project = Project::create($data);
            $project->fond()->associate($fond);
            $project->baseHelpTypes()->sync($request->base_help_types);
            $partners = $request->get('partnerName');
            $sponsors = $request->get('sponsorName');
            $companies = $request->get('companyName');
            $humans = $request->get('humanName');
            foreach($partners as $k => $item){
                $partner = new ProjectPartners();
                $partner->project_id = $fond->id;
                $partner->name = $item;
                $partner->url = $request->get('partnerSite')[$k];
                $partner->save();
            }
            foreach($sponsors as $k => $item){
                $sponsor = new ProjectSponsors();
                $sponsor->project_id = $fond->id;
                $sponsor->name = $item;
                $sponsor->url = $request->get('sponsorSite')[$k];
                $sponsor->save();
            }
            foreach($companies as $k => $item){
                $company = new ProjectCompanies();
                $company->project_id = $fond->id;
                $company->name = $item;
                $company->url = $request->get('companySite')[$k];
                $company->summ = $request->get('companySumm')[$k];
                $company->save();
            }
            foreach($humans as $k => $item){
                $human = new ProjectHumans();
                $human->project_id = $fond->id;
                $human->name = $item;
                $human->summ = $request->get('humanSumm')[$k];
                $human->save();
            }
        } elseif ($request->method() == 'GET') {
            $baseHelpTypes = AddHelpType::all()->toArray();
            $regions = Region::all();
            $cities = City::all();
            $scenarios = Scenario::all();
            return view('backend.fond_cabinet.projects.create_project')->with(compact('baseHelpTypes', 'regions', 'cities','scenarios'));
        }
    }


    public function update(Request $request)
    {
        if ($request->method() == 'POST') {
            $validator = Validator::make($request->all(),
                [
                    'title_ru' => 'required|min:3',
                    'image' => 'mimes:jpeg,jpg,png|max:10000',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $socials = [];
            foreach ($request->socials as $key => $social) {
                array_push($socials, ['name' => $key, 'link' => $social]);
            }

            $data = $request->all();
            $data['requisites'] = json_encode($request->requisites, JSON_UNESCAPED_UNICODE);
            $data['offices'] = json_encode($request->offices, JSON_UNESCAPED_UNICODE);
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

            $fond->update($data);
            return redirect()->back()->with(['success' => 'Информация успешно обновлена']);


        } else {
            return redirect()->back();
        }
    }

    public function helpPage($id){
        $help = Help::find($id);
        $cashHelpTypes = CashHelpType::all();
        $finished_helps = Help::whereFondStatus('finished')->paginate(4);
        return view('backend.fond_cabinet.help_page')->with(compact('help','finished_helps', 'cashHelpTypes'));
    }
}
