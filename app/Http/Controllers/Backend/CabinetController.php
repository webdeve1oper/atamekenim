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

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $waitHelps = Auth::user()->helpsByStatus('wait')->with('fonds')->with('reviews')->get();
        $finishedHelps = Auth::user()->helpsByStatus('finished')->with('fonds')->with('reviews')->get();
        $processHelps = Auth::user()->helpsByStatus('process')->with('fonds')->with('reviews')->get();

        return view('backend.cabinet.index')->with(compact('waitHelps', 'finishedHelps', 'processHelps'));
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

        $fonds = Fond::whereIn('id', $data['fond'])->count();

        if($fonds == count($data['fond'])){
            $help->fond()->attach($data['fond']);
        }else{
            return redirect()->back()->with(['error'=>'Укажите хотябы один фонд']);
        }

        if(isset($data['baseHelpTypes'])) {
            $help->baseHelpTypes()->attach($data['baseHelpTypes']);
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
}
