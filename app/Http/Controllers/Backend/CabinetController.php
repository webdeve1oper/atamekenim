<?php

namespace App\Http\Controllers\Backend;

use App\AddHelpType;
use App\BaseHelpType;
use App\Fond;
use App\Help;
use App\Http\Controllers\Controller;
use App\Review;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Image;
use App\Scenario;
use App\Region;
use App\Destination;
use App\CashHelpType;
use App\CashHelpSize;

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $moderateHelps = Auth::user()->helpsByStatus('moderate')->with('fonds')->with('reviews')->get();
        $waitHelps = Auth::user()->helpsByStatus('wait')->with('fonds')->with('reviews')->get();
        $finishedHelps = Auth::user()->helpsByStatus('finished')->with('fonds')->with('reviews')->get();
        $processHelps = Auth::user()->helpsByStatus('process')->with('fonds')->with('reviews')->get();

        return view('backend.cabinet.index')->with(compact('waitHelps', 'finishedHelps', 'processHelps','moderateHelps'));
    }

    public function create(){
        $baseHelpTypes = BaseHelpType::all();
        $addHelpTypes = AddHelpType::all();
        $fonds = Fond::all();

        return view('backend.cabinet.help.create')->with(compact('baseHelpTypes', 'addHelpTypes', 'fonds'));
    }


    public function help(Request $request){
        $validator = Validator::make($request->all(),
            [
                'title'=>'required|min:5',
                'body'=>'required|min:5',
                'baseHelpTypes'=>'required',
                'addHelpTypes'=>'required',
                'city_id'=>'required',
                'region_id'=>'required',
            ],
            [
                'title.required'=>'Поле обязательно для заполнения'
            ]
        );
        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        unset($data['_token']);
        $help = Help::create($data);

        $fonds = Fond::pluck('id');
//        $fonds = Fond::whereIn('id', $data['fond'])->count();

        if($fonds == count($fonds)){
            $help->fond()->attach($fonds);
        }else{
            return redirect()->back()->with(['error'=>'Укажите хотябы один фонд']);
        }

        if(isset($data['addHelpTypes']) && count($data['addHelpTypes'])>0){
            $help->addHelpTypes()->attach($data['addHelpTypes']);
        }

        if($help){
            return redirect()->back()->with(['success'=>'Заявка успешно принята']);
        }else{
            return redirect()->back()->with(['error'=>'Что то пошло не так. Попробуйте снова']);
        }

    }

    public function review_to_fond(Request $request){
        $validator = Validator::make($request->all(),
            [
                'title'=>'required|min:10',
                'body'=>'required|min:100',
            ]
        );
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $help = Help::findOrFail($data['help_id']);
        if($help->status != 'finished'){
            return redirect()->back()->with('error', 'Заявка еще не завершена!');
        }
        $data['user_id'] = Auth::user()->id;
        Review::create($data);
        return redirect()->back()->with('success', 'Отзыв отправлен!');
    }

    public function helpPage($id){
        $help = Help::find($id);
        return view('backend.cabinet.help.help_page')->with(compact('help'));
    }

    public function editUser(){
        $user = User::find(Auth::user()->id);
            return view('backend.cabinet.edit_info')->with(compact('user'));
    }
    public function updateUser(Request $request){
        $user = User::find(Auth::user()->id);
        if($request){
                $validator = Validator::make($request->all(),
                    [
                        'avatar' => 'mimes:jpeg,jpg,png|max:1000',
                    ]
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                if($request->file('avatar')){
                    $originalImage = $request->file('avatar');
                    $thumbnailImage = Image::make($originalImage);
                    $thumbnailPath = '/img/avatars';
                    File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                    $path = microtime() . '.' . $originalImage->getClientOriginalExtension();
                    $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                    $user->avatar = $thumbnailPath . '/' . $path;
                }
                $user->email = $request->email;
                $user->about = $request->about;
                $user->save();
                return redirect()->route('cabinet')->with(['success' => 'Личная информация успешно обновлена!']);
        }else{
            return redirect()->route('cabinet')->with(['error' => 'Что то пошло не так!']);
        }
    }

    public function editPage($id){
        $help = Help::find($id);
        if($help->user_id == Auth::user()->id){
            $scenarios = Scenario::select('id', 'name_ru', 'name_kz')->with(['addHelpTypes', 'destinations'])->get()->toArray();
            $baseHelpTypes = AddHelpType::all();
            $regions = Region::select('region_id', 'title_ru as text')->with('districts.cities')->limit(10)->get();
            $destinations = Destination::all();
            $cashHelpTypes = CashHelpType::all();
            $cashHelpSizes = CashHelpSize::all();
            return view('backend.cabinet.help.help_edit')->with(compact('help', 'scenarios', 'baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes'));
        }else{
            return redirect()->route('cabinet')->with(['error' => 'Это заявка не пренадлежит Вам!']);
        }
    }

    public function updateHelp(Request $request, $help_id){
//        $validator = Validator::make($request->all(),
//            [
//                'body'=>'required|min:5',
//                'baseHelpTypes'=>'required',
//                'addHelpTypes'=>'required',
//                'city_id'=>'required',
//                'region_id'=>'required',
//            ],
//            [
//                'title.required'=>'Поле обязательно для заполнения'
//            ]
//        );
//        if($validator->fails()){
//            return redirect()->back()->withErrors($validator->errors());
//        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['admin_status'] = "moderate";
        $data['fond_status'] = "moderate";
        unset($data['_token']);
        $help = Help::whereId($help_id)->first();
        $fonds = Fond::pluck('id');
        if (isset($request->destinations) && !empty($request->destinations)) {
            $help->destinations()->sync($request->destinations);
        }
        if (isset($request->baseHelpTypes) && !empty($request->baseHelpTypes)) {
            $help->addHelpTypes()->sync($request->baseHelpTypes);
        }
        if (isset($request->cashHelpTypes) && !empty($request->cashHelpTypes)) {
            $help->cashHelpTypes()->sync($request->cashHelpTypes);
        }
        $help->fonds()->sync($fonds);
        $help->update($data);
        return redirect()->back()->with(['success' => 'Ваша заявка усешно обновлена!']);

    }
}
