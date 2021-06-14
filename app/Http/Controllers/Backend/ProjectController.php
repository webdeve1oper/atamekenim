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
//            dd($request->all());
            $originalImage = $request->file('logo');
            $thumbnailImage = Image::make($originalImage);
            $thumbnailPath = '/img/projects';
            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
            $path = time() . '.' . $originalImage->getClientOriginalExtension();
            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
            $data['logo'] = $thumbnailPath . '/' . $path;

            $data['fond_id'] = $fond->id;
            $project = Project::create($data);
            $project->fond()->associate($fond);
            $project->baseHelpTypes()->sync($request->base_help_types);

            $partners = $request->get('partnerName');
            $sponsors = $request->get('sponsorName');
            $companies = $request->get('companyName');
            $humans = $request->get('humanName');
            if ($partners) {
                foreach ($partners as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $partner = new ProjectPartners();
                        $partner->project_id = $project->id;
                        $partner->name = $item;
                        $partner->url = $request->get('partnerSite')[$k];
                        if($request->file('partnerImg')[$k]){
                            $originalImage = $request->file('partnerImg')[$k];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = time() . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $partner->logo = $thumbnailPath . '/' . $path;
                        }
                        $partner->save();
                    }

                }
            }
            if ($sponsors) {
                foreach ($sponsors as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $sponsor = new ProjectSponsors();
                        $sponsor->project_id = $project->id;
                        $sponsor->name = $item;
                        $sponsor->url = $request->get('sponsorSite')[$k];
                        if($request->file('sponsorImg')[$k]){
                            $originalImage = $request->file('sponsorImg')[$k];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = time() . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $sponsor->logo = $thumbnailPath . '/' . $path;
                        }
                        $sponsor->save();
                    }
                }
            }
            if ($companies) {
                foreach ($companies as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $company = new ProjectCompanies();
                        $company->project_id = $project->id;
                        $company->name = $item;
                        $company->url = $request->get('companySite')[$k];
                        $company->summ = $request->get('companySumm')[$k];
                        if($request->file('companyImg')[$k]){
                            $originalImage = $request->file('companyImg')[$k];
                            $thumbnailImage = Image::make($originalImage);
                            $thumbnailPath = '/img/projects';
                            File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                            $path = time() . '.' . $originalImage->getClientOriginalExtension();
                            $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                            $company->logo = $thumbnailPath . '/' . $path;
                        }
                        $company->save();
                    }
                }
            }
            if ($humans) {
                foreach ($humans as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $human = new ProjectHumans();
                        $human->project_id = $project->id;
                        $human->name = $item;
                        $human->summ = $request->get('humanSumm')[$k];
                        if($request->get('humanIncognito')[$k]){
                            $human->incognito = $request->get('humanIncognito')[$k];
                        }
                        $human->save();
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
            $project->baseHelpTypes()->sync($request->base_help_types);
            $project->scenarios()->sync($request->scenario_id);

            $partners = $request->get('partnerName');
            $sponsors = $request->get('sponsorName');
            $companies = $request->get('companyName');
            $humans = $request->get('humanName');
            if ($partners) {
                foreach ($partners as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $partner = new ProjectPartners();
                        $partner->project_id = $project->id;
                        $partner->name = $item;
                        $partner->url = $request->get('partnerSite')[$k];
                        $partner->save();
                    }

                }
            }
            if ($sponsors) {
                foreach ($sponsors as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $sponsor = new ProjectSponsors();
                        $sponsor->project_id = $project->id;
                        $sponsor->name = $item;
                        $sponsor->url = $request->get('sponsorSite')[$k];
                        $sponsor->save();
                    }
                }
            }
            if ($companies) {
                foreach ($companies as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $company = new ProjectCompanies();
                        $company->project_id = $project->id;
                        $company->name = $item;
                        $company->url = $request->get('companySite')[$k];
                        $company->summ = $request->get('companySumm')[$k];
                        $company->save();
                    }
                }
            }
            if ($humans) {
                foreach ($humans as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $human = new ProjectHumans();
                        $human->project_id = $project->id;
                        $human->name = $item;
                        $human->summ = $request->get('humanSumm')[$k];
                        $human->save();
                    }
                }
            }

            $partnersExist = $request->get('partnerId');
            $sponsorsExist = $request->get('sponsorId');
            $companiesExist = $request->get('companyId');
            $humansExist = $request->get('humanId');
            if ($partnersExist) {
                foreach ($partnersExist as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $partnerExist = ProjectPartners::find($item);
                        if($request->get('partnerDelete')[$k] == '2'){
                            ProjectPartners::destroy($partnerExist->id);
                        }else{
                            $partnerExist->name = $request->get('partnerExistName')[$k];
                            $partnerExist->url = $request->get('partnerExistSite')[$k];
                            $partnerExist->save();
                        }
                    }

                }
            }
            if ($sponsorsExist) {
                foreach ($sponsorsExist as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $sponsorExist = ProjectSponsors::find($item);
                        if($request->get('sponsorDelete')[$k] == '2'){
                            ProjectPartners::destroy($sponsorExist->id);
                        }else{
                            $sponsorExist->name = $request->get('sponsorExistName')[$k];
                            $sponsorExist->url = $request->get('sponsorExistSite')[$k];
                            $sponsorExist->save();
                        }
                    }

                }
            }
            if ($companiesExist) {
                foreach ($companiesExist as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $companyExist = ProjectCompanies::find($item);
                        if($request->get('companyDelete')[$k] == '2'){
                            ProjectPartners::destroy($companyExist->id);
                        }else{
                            $companyExist->name = $request->get('companyExistName')[$k];
                            $companyExist->summ = $request->get('companyExistSumm')[$k];
                            $companyExist->url = $request->get('companyExistSite')[$k];
                            $companyExist->save();
                        }
                    }

                }
            }
            if ($humansExist) {
                foreach ($humansExist as $k => $item) {
                    if ($item == null) {
                        continue;
                    } else {
                        $humanExist = ProjectHumans::find($item);
                        if($request->get('companyDelete')[$k] == '2'){
                            ProjectPartners::destroy($humanExist->id);
                        }else{
                            $humanExist->name = $request->get('humanExistName')[$k];
                            $humanExist->summ = $request->get('humanExistSumm')[$k];
                            $humanExist->save();
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
            return view('backend.fond_cabinet.projects.update_project')->with(compact('project','baseHelpTypes','regions','cities','scenarios','companies','sponsors','partners','humans'));
        }
    }
}
