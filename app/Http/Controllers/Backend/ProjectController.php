<?php

namespace App\Http\Controllers\Backend;

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
use App\Help;
use App\History;
use App\Partner;
use App\Project;
use App\ProjectCompanies;
use App\ProjectGallery;
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

class ProjectController extends Controller
{
    public function index($id){
        $project = Project::find($id);
        return view('frontend.fond.project')->with(compact('project'));
    }

    public function projects(Request $request){
        $projects = Project::whereFondId(Auth::user()->id)->get();
        return view('backend.fond_cabinet.projects.projects')->with(compact('projects'));
    }

    public function projectPage($id){
        $project = Project::find($id);
        $baseHelpTypes = AddHelpType::all()->toArray();
        $regions = Region::all();
        $cities = City::all();
        $scenarios = Scenario::all();

        $companies = ProjectCompanies::where('project_id', $project->id)->get();
        $sponsors = ProjectSponsors::where('project_id', $project->id)->get();
        $partners = ProjectPartners::where('project_id', $project->id)->get();
        $humans = ProjectHumans::where('project_id', $project->id)->get();
        return view('backend.fond_cabinet.projects.project_page')->with(compact('project','baseHelpTypes','regions','cities','scenarios','companies','sponsors','partners','humans'));
    }
    public function createProject(Request $request)
    {
        if ($request->method() == 'POST') {
            $allInputs = $request->all();
            $validator = Validator::make($request->all(),
                [
                    'title' => 'required|min:3',
                    'logo' => 'mimes:jpeg,jpg,png|max:1000',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $fields =[];
            $rules =[];
            if(array_key_exists('partnerImg',$allInputs)){
                foreach ($allInputs['partnerImg']  as $key => $percent) {
                    $fields['partnerImg['.$key.']'] = $percent;
                    $rules['partnerImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if(array_key_exists('sponsorImg',$allInputs)){
                foreach ($allInputs['sponsorImg']  as $key => $percent) {
                    $fields['sponsorImg[['.$key.']'.']'] = $percent;
                    $rules['sponsorImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if(array_key_exists('companyImg',$allInputs)){
                foreach ($allInputs['companyImg']  as $key => $percent) {
                    $fields['companyImg[['.$key.']'.']'] = $percent;
                    $rules['companyImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if(array_key_exists('gallery',$allInputs)){
                foreach ($allInputs['gallery']  as $key => $percent) {
                    $fields['gallery['.$key.']'] = $percent;
                    $rules['gallery['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            $validator = Validator::make($fields, $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $fond = Fond::find(Auth::user()->id);
            $data = $request->all();
            if($request->file('logo')){
                $originalImage = $request->file('logo');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = '/img/projects';
                File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                $path = microtime() . '.' . $originalImage->getClientOriginalExtension();
                $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                $data['logo'] = $thumbnailPath . '/' . $path;
            }
            $data['fond_id'] = $fond->id;
            $project = Project::create($data);
            $project->fond()->associate($fond);
            $project->AddHelpType()->sync($request->base_help_types);
            $project->scenarios()->sync($request->scenario_id);

            if($request->region) {
                $project->regions()->sync($request->region);
            }
            if($request->district) {
                $project->districts()->sync($request->district);
            }
            if($request->city){
                $project->cities()->sync($request->city);
            }

            $partners = $request->get('partnerName');
            $sponsors = $request->get('sponsorName');
            $companies = $request->get('companyName');
            $humans = $request->get('humanName');
            $gallery = $request->file('gallery');

            if ($partners) {
                $this->createItem('App\ProjectPartners', $partners, 'partner', $project,$request);
            }
            if ($sponsors) {
                $this->createItem('App\ProjectSponsors', $sponsors, 'sponsor', $project,$request);
            }
            if ($companies) {
                $this->createItem('App\ProjectCompanies', $companies, 'company', $project,$request);
            }
            if ($humans) {
                $this->createItem('App\ProjectHumans', $humans, 'human', $project,$request);
            }

            if ($gallery) {
                $this->createItem('App\ProjectGallery', $gallery, 'gallery', $project,$request);
            }

            return redirect()->route('projects')->with(['success' => 'Проект успешно добавлен']);
        } elseif ($request->method() == 'GET') {
            $baseHelpTypes = AddHelpType::all()->toArray();
            $regions = Region::all();
            $cities = City::all();
            $scenarios = Scenario::all();
            return view('backend.fond_cabinet.projects.create_project')->with(compact('baseHelpTypes', 'regions', 'cities', 'scenarios'));
        }
    }


    public function updatePage(Request $request, $id){
        if ($request->method() == 'POST') {
            $allInputs = $request->all();
            $validator = Validator::make($request->all(),
                [
                    'title' => 'required|min:3',
                    'logo' => 'mimes:jpeg,jpg,png|max:1000',
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $fields =[];
            $rules =[];
            if(array_key_exists('partnerImg',$allInputs)){
                foreach ($allInputs['partnerImg']  as $key => $percent) {
                    $fields['partnerImg['.$key.']'] = $percent;
                    $rules['partnerImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if(array_key_exists('sponsorImg',$allInputs)){
                foreach ($allInputs['sponsorImg']  as $key => $percent) {
                    $fields['sponsorImg[['.$key.']'.']'] = $percent;
                    $rules['sponsorImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if(array_key_exists('companyImg',$allInputs)){
                foreach ($allInputs['companyImg']  as $key => $percent) {
                    $fields['companyImg[['.$key.']'.']'] = $percent;
                    $rules['companyImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if(array_key_exists('gallery',$allInputs)){
                foreach ($allInputs['gallery']  as $key => $percent) {
                    $fields['gallery['.$key.']'] = $percent;
                    $rules['gallery['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            $validator = Validator::make($fields, $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $fond = Fond::find(Auth::user()->id);
            $data = $request->all();
            if($request->file('logo')){
                $originalImage = $request->file('logo');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = '/img/projects';
                File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                $path = time() . '.' . $originalImage->getClientOriginalExtension();
                $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                $data['logo'] = $thumbnailPath . '/' . $path;
            }

            $data['fond_id'] = $fond->id;
            $project = Project::find($id);
            $project->update($data);
            $project->fond()->associate($fond);
            $project->AddHelpType()->sync($request->base_help_types);
            $project->scenarios()->sync($request->scenario_id);



            $project->regions()->sync($request->region);
            $project->districts()->sync($request->district);
            $project->cities()->sync($request->city);

            $partners = $request->get('partnerName');
            $sponsors = $request->get('sponsorName');
            $companies = $request->get('companyName');
            $humans = $request->get('humanName');
            $gallery = $request->file('gallery');

            if ($partners) {
                $this->createItem('App\ProjectPartners', $partners, 'partner', $project,$request);
            }
            if ($sponsors) {
                $this->createItem('App\ProjectSponsors', $sponsors, 'sponsor', $project,$request);
            }
            if ($companies) {
                $this->createItem('App\ProjectCompanies', $companies, 'company', $project,$request);
            }
            if ($humans) {
                $this->createItem('App\ProjectHumans', $humans, 'human', $project,$request);
            }

            if ($gallery) {
                $this->createItem('App\ProjectGallery', $gallery, 'gallery', $project,$request);
            }

            $partnersExist = $request->get('partnerId');
            $sponsorsExist = $request->get('sponsorId');
            $companiesExist = $request->get('companyId');
            $humansExist = $request->get('humanId');
            $galleryExist = $request->get('galleryId');
            if ($partnersExist) {
                $this->editItem('App\ProjectPartners', $partnersExist, 'partner', $request);
            }
            if ($sponsorsExist) {
                $this->editItem('App\ProjectSponsors', $sponsorsExist, 'sponsor', $request);
            }
            if ($companiesExist) {
                $this->editItem('App\ProjectCompanies', $companiesExist, 'company', $request);
            }
            if ($humansExist) {
                $this->editItem('App\ProjectHumans', $humansExist, 'human', $request);
            }
            if ($galleryExist) {
                $this->editItem('App\ProjectGallery', $galleryExist, 'gallery', $request);
            }


            return redirect()->route('projects')->with(['success' => 'Проект успешно обновлен!']);
        } elseif ($request->method() == 'GET') {
            $project = Project::find($id);
            $baseHelpTypes = AddHelpType::all()->toArray();
            $regions = Region::all();
            $cities = City::all();
            $scenarios = Scenario::all();

            $companies = ProjectCompanies::where('project_id', $project->id)->get();
            $sponsors = ProjectSponsors::where('project_id', $project->id)->get();
            $partners = ProjectPartners::where('project_id', $project->id)->get();
            $humans = ProjectHumans::where('project_id', $project->id)->get();
            $gallery = ProjectGallery::where('project_id', $project->id)->get();
            return view('backend.fond_cabinet.projects.update_project')->with(compact('project','baseHelpTypes','regions','cities','scenarios','companies','sponsors','partners','humans','gallery'));
        }
    }

    public function createItem($model, $arrayBase, $name, $project, $request){
        foreach ($arrayBase as $k1 => $item) {
            if ($item == null) {
                continue;
            } else {

                $partner = new $model;
                $partner->project_id = $project->id;
                if($name != 'gallery') {
                    $partner->name = $item;
                }
                if($name == 'company' or $name == 'human'){
                    $partner->summ = $request->get($name.'Summ')[$k1];
                }
                if($name == 'human'){
                    $partner->incognito = $request->get('humanIncognito')[$k1];
                }
                if($name != 'human'){
                    if($name != 'gallery'){
                        $partner->url = $request->get($name.'Site')[$k1];
                        if(array_key_exists($k1, $request->file($name.'Img'))){
                            $originalImage = $request->file($name.'Img')[$k1];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = microtime(). $k1 . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $partner->logo = $thumbnailPath . '/' . $path;
                        }
                    }else{
                        $originalImage = $item;
                        $thumbnailImage = Image::make($originalImage);
                        $thumbnailPath = '/img/projects';
                        File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                        $path = microtime(). $k1 . '.' . $originalImage->getClientOriginalExtension();
                        $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                        $partner->img = $thumbnailPath . '/' . $path;
                    }
                }
                $partner->save();
            }

        }
    }

    public function editItem($model, $arrayBase, $name, $request){
        foreach ($arrayBase as $k5 => $item) {
            if ($item == null) {
                continue;
            } else {
                $partnerExist = $model::find($item);
                if($request->get($name.'Delete')[$k5] == '2'){
                    $model::destroy($partnerExist->id);
                }else{
                    if($name != 'gallery'){
                        $partnerExist->name = $request->get($name.'ExistName')[$k5];
                        if($name != 'human'){
                            $partnerExist->url = $request->get($name.'ExistSite')[$k5];
                        }
                        if($name == 'company' or $name == 'human'){
                            $partnerExist->summ = $request->get($name.'ExistSumm')[$k5];
                            if($name == 'human'){
                                $partnerExist->incognito = $request->get($name.'ExistIncognito')[$k5];
                            }
                        }
                        if($request->file($name.'ExistImg')){
                            if(array_key_exists($k5, $request->file($name.'ExistImg'))){
                                $originalImage = $request->file($name.'ExistImg')[$k5];
                                $thumbnailImage = Image::make($originalImage);
                                $thumbnailPath = '/img/projects';
                                File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                                $path = microtime(). $k5 . '.' . $originalImage->getClientOriginalExtension();
                                $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                                $partnerExist->logo = $thumbnailPath . '/' . $path;
                            }
                        }
                        $partnerExist->save();
                    }else{
                        continue;
                    }
                }
            }

        }
    }
}
