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
            if($allInputs['partnerImg']){
                foreach ($allInputs['partnerImg']  as $key => $percent) {
                    $fields['partnerImg['.$key.']'] = $percent;
                    $rules['partnerImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if($allInputs['sponsorImg']){
                foreach ($allInputs['sponsorImg']  as $key => $percent) {
                    $fields['sponsorImg[['.$key.']'.']'] = $percent;
                    $rules['sponsorImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if($allInputs['companyImg']){
                foreach ($allInputs['companyImg']  as $key => $percent) {
                    $fields['companyImg[['.$key.']'.']'] = $percent;
                    $rules['companyImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if($allInputs['gallery']){
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
            $originalImage = $request->file('logo');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = '/img/projects';
            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
            $path = microtime() . '.' . $originalImage->getClientOriginalExtension();
            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
            $data['logo'] = $thumbnailPath . '/' . $path;

            $data['fond_id'] = $fond->id;
            $project = Project::create($data);
            $project->fond()->associate($fond);
            $project->AddHelpType()->sync($request->base_help_types);
            $project->scenarios()->sync($request->scenario_id);

            $partners = $request->get('partnerName');
            $sponsors = $request->get('sponsorName');
            $companies = $request->get('companyName');
            $humans = $request->get('humanName');
            if ($partners) {
                foreach ($partners as $k1 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $partner = new ProjectPartners();
                        $partner->project_id = $project->id;
                        $partner->name = $item;
                        $partner->url = $request->get('partnerSite')[$k1];
                        if(array_key_exists($k1, $request->file('partnerImg'))){
                            $originalImage = $request->file('partnerImg')[$k1];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = microtime(). $k1 . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $partner->logo = $thumbnailPath . '/' . $path;
                        }
                        $partner->save();
                    }

                }
            }
            if ($sponsors) {
                foreach ($sponsors as $k2 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $sponsor = new ProjectSponsors();
                        $sponsor->project_id = $project->id;
                        $sponsor->name = $item;
                        $sponsor->url = $request->get('sponsorSite')[$k2];
                        if(array_key_exists($k2, $request->file('sponsorImg'))){
                            $originalImage = $request->file('sponsorImg')[$k2];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = microtime(). $k2 . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $sponsor->logo = $thumbnailPath . '/' . $path;
                        }
                        $sponsor->save();
                    }
                }
            }
            if ($companies) {
                foreach ($companies as $k3 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $company = new ProjectCompanies();
                        $company->project_id = $project->id;
                        $company->name = $item;
                        $company->url = $request->get('companySite')[$k3];
                        $company->summ = $request->get('companySumm')[$k3];
                        if(array_key_exists($k3, $request->file('companyImg'))){
                            $originalImage = $request->file('companyImg')[$k3];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = microtime(). $k3 . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $company->logo = $thumbnailPath . '/' . $path;
                        }
                        $company->save();
                    }
                }
            }
            if ($humans) {
                foreach ($humans as $k4 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $human = new ProjectHumans();
                        $human->project_id = $project->id;
                        $human->name = $item;
                        $human->summ = $request->get('humanSumm')[$k4];
                        $human->incognito = $request->get('humanIncognito')[$k4];
                        $human->save();
                    }
                }
            }
            $gallery = $request->file('gallery');
            if ($gallery) {
                foreach ($gallery as $key => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $galleryItem = new ProjectGallery();
                        $galleryItem->project_id = $project->id;
                        $originalImage = $item;
                        $thumbnailImage = Image::make($originalImage);
                        $thumbnailPath = '/img/projects';
                        File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                        $path = microtime(). $key . '.' . $originalImage->getClientOriginalExtension();
                        $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                        $galleryItem->img = $thumbnailPath . '/' . $path;
                        $galleryItem->save();
                    }

                }
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
            if($allInputs['partnerImg']){
                foreach ($allInputs['partnerImg']  as $key => $percent) {
                    $fields['partnerImg['.$key.']'] = $percent;
                    $rules['partnerImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if($allInputs['sponsorImg']){
                foreach ($allInputs['sponsorImg']  as $key => $percent) {
                    $fields['sponsorImg[['.$key.']'.']'] = $percent;
                    $rules['sponsorImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if($allInputs['companyImg']){
                foreach ($allInputs['companyImg']  as $key => $percent) {
                    $fields['companyImg[['.$key.']'.']'] = $percent;
                    $rules['companyImg['.$key.']'] = 'mimes:jpeg,jpg,png|max:1000';
                }
            }
            if($allInputs['gallery']){
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
//            dd($request->all());
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

            $partners = $request->get('partnerName');
            $sponsors = $request->get('sponsorName');
            $companies = $request->get('companyName');
            $humans = $request->get('humanName');
            if ($partners) {
                foreach ($partners as $k1 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $partner = new ProjectPartners();
                        $partner->project_id = $project->id;
                        $partner->name = $item;
                        $partner->url = $request->get('partnerSite')[$k1];
                        if(array_key_exists($k1, $request->file('partnerImg'))){
                            $originalImage = $request->file('partnerImg')[$k1];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = microtime(). $k1 . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $partner->logo = $thumbnailPath . '/' . $path;
                        }
                        $partner->save();
                    }

                }
            }
            if ($sponsors) {
                foreach ($sponsors as $k2 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $sponsor = new ProjectSponsors();
                        $sponsor->project_id = $project->id;
                        $sponsor->name = $item;
                        $sponsor->url = $request->get('sponsorSite')[$k2];
                        if(array_key_exists($k2, $request->file('sponsorImg'))){
                            $originalImage = $request->file('sponsorImg')[$k2];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = microtime(). $k2 . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $sponsor->logo = $thumbnailPath . '/' . $path;
                        }
                        $sponsor->save();
                    }
                }
            }
            if ($companies) {
                foreach ($companies as $k3 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $company = new ProjectCompanies();
                        $company->project_id = $project->id;
                        $company->name = $item;
                        $company->url = $request->get('companySite')[$k3];
                        $company->summ = $request->get('companySumm')[$k3];
                        if(array_key_exists($k3, $request->file('companyImg'))){
                            $originalImage = $request->file('companyImg')[$k3];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = microtime(). $k3 . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $company->logo = $thumbnailPath . '/' . $path;
                        }
                        $company->save();
                    }
                }
            }
            function createFunction(){

            }
            if ($humans) {
                foreach ($humans as $k4 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $human = new ProjectHumans();
                        $human->project_id = $project->id;
                        $human->name = $item;
                        $human->summ = $request->get('humanSumm')[$k4];
                        $human->incognito = $request->get('humanIncognito')[$k4];
                        $human->save();
                    }
                }
            }

            $partnersExist = $request->get('partnerId');
            $sponsorsExist = $request->get('sponsorId');
            $companiesExist = $request->get('companyId');
            $humansExist = $request->get('humanId');
            if ($partnersExist) {
                foreach ($partnersExist as $k5 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $partnerExist = ProjectPartners::find($item);
                        if($request->get('partnerDelete')[$k5] == '2'){
                            ProjectPartners::destroy($partnerExist->id);
                        }else{
                            $partnerExist->name = $request->get('partnerExistName')[$k5];
                            $partnerExist->url = $request->get('partnerExistSite')[$k5];
                            if($request->file('partnerExistImg')){
                                if(array_key_exists($k5, $request->file('partnerExistImg'))){
                                    $originalImage = $request->file('partnerExistImg')[$k5];
                                    $thumbnailImage = Image::make($originalImage);
                                    $thumbnailPath = '/img/projects';
                                    File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                                    $path = microtime(). $k5 . '.' . $originalImage->getClientOriginalExtension();
                                    $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                                    $partnerExist->logo = $thumbnailPath . '/' . $path;
                                }
                            }
                            $partnerExist->save();
                        }
                    }

                }
            }
            if ($sponsorsExist) {
                foreach ($sponsorsExist as $k6 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $sponsorExist = ProjectSponsors::find($item);
                        if($request->get('sponsorDelete')[$k6] == '2'){
                            ProjectSponsors::destroy($sponsorExist->id);
                        }else{
                            $sponsorExist->name = $request->get('sponsorExistName')[$k6];
                            $sponsorExist->url = $request->get('sponsorExistSite')[$k6];
                            if($request->file('sponsorExistImg')) {
                                if (array_key_exists($k6, $request->file('sponsorExistImg'))) {
                                    $originalImage = $request->file('sponsorExistImg')[$k6];
                                    $thumbnailImage = Image::make($originalImage);
                                    $thumbnailPath = '/img/projects';
                                    File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                                    $path = microtime() . $k6 . '.' . $originalImage->getClientOriginalExtension();
                                    $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                                    $sponsorExist->logo = $thumbnailPath . '/' . $path;
                                }
                            }
                            $sponsorExist->save();
                        }
                    }

                }
            }
            if ($companiesExist) {
                foreach ($companiesExist as $k7 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $companyExist = ProjectCompanies::find($item);
                        if($request->get('companyDelete')[$k7] == '2'){
                            ProjectCompanies::destroy($companyExist->id);
                        }else{
                            $companyExist->name = $request->get('companyExistName')[$k7];
                            $companyExist->summ = $request->get('companyExistSumm')[$k7];
                            $companyExist->url = $request->get('companyExistSite')[$k7];
                            if($request->file('companyExistImg')) {
                                if (array_key_exists($k7, $request->file('companyExistImg'))) {
                                    $originalImage = $request->file('companyExistImg')[$k7];
                                    $thumbnailImage = Image::make($originalImage);
                                    $thumbnailPath = '/img/projects';
                                    File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                                    $path = microtime() . $k7 . '.' . $originalImage->getClientOriginalExtension();
                                    $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                                    $companyExist->logo = $thumbnailPath . '/' . $path;
                                }
                            }
                            $companyExist->save();
                        }
                    }

                }
            }
            if ($humansExist) {
                foreach ($humansExist as $k8 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $humanExist = ProjectHumans::find($item);
                        if($request->get('companyDelete')[$k8] == '2'){
                            ProjectHumans::destroy($humanExist->id);
                        }else{
                            $humanExist->name = $request->get('humanExistName')[$k8];
                            $humanExist->summ = $request->get('humanExistSumm')[$k8];
                            $humanExist->incognito = $request->get('humanExistIncognito')[$k8];
                            $humanExist->save();
                        }
                    }

                }
            }

            $gallery = $request->file('gallery');
            if ($gallery) {
                foreach ($gallery as $key => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $galleryItem = new ProjectGallery();
                        $galleryItem->project_id = $project->id;
                        $originalImage = $item;
                        $thumbnailImage = Image::make($originalImage);
                        $thumbnailPath = '/img/projects';
                        File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                        $path = microtime(). $key . '.' . $originalImage->getClientOriginalExtension();
                        $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                        $galleryItem->img = $thumbnailPath . '/' . $path;
                        $galleryItem->save();
                    }

                }
            }
            $galleryExist = $request->get('galleryId');
            if ($galleryExist) {
                foreach ($galleryExist as $key2 => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $galleryItemExist = ProjectGallery::find($item);
                        if($request->get('galleryDelete')[$key2] == '2'){
                            ProjectGallery::destroy($galleryItemExist->id);
                        }else{
                            continue;
                        }
                    }

                }
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
}
