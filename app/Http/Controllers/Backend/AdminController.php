<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Help;
use App\Fond;
use App\History;
use App\HistoryFond;
use App\Admin;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //

    public function index()
    {
        return view('backend.admin.home');
    }

    public function showHelps(){
        if(Auth::user()->role_id <= 2){
            $helps1 = Help::where('admin_status','moderate')->get();
            $helps2 = Help::where('admin_status','finished')->get();
            $helps3 = Help::where('fond_status','process')->get();
            $helps4 = Help::where('admin_status','cancel')->get();
            $helps5 = Help::where('admin_status','edit')->get();
            $helps6 = Help::where('fond_status','finished')->get();
            return view('backend.admin.helps')->with(compact('helps1','helps2','helps3','helps4','helps5','helps6'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    public function showFonds(){
        if(Auth::user()->role_id <= 2){
            $fonds1 = Fond::all();
            $fonds2 = Fond::where('status', 1)->get();
            $fonds3 = Fond::where('status', 0)->get();
            $fonds4 = Fond::where('status', 2)->get();
            return view('backend.admin.fonds')->with(compact('fonds1','fonds2','fonds3','fonds4'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    public function showHelpsFromCategory($category){
        if(Auth::user()->role_id <= 2){
            switch ($category) {
                case 'moderate':
                    $title = 'На модерации';
                    $helps = Help::where('admin_status', $category)->get();
                    break;
                case 'finished':
                    $title = 'В ожидании благотворителя';
                    $helps = Help::where('admin_status', $category)->get();
                    break;
                case 'fond_process':
                    $title = 'В работе';
                    $helps = Help::where('fond_status', 'process')->get();
                    break;
                case 'cancel':
                    $title = 'Отклонена';
                    $helps = Help::where('admin_status', $category)->get();
                    break;
                case 'edit':
                    $title = 'Требует правок';
                    $helps = Help::where('admin_status', $category)->get();
                    break;
                case 'fond_finished':
                    $title = 'Исполнена';
                    $helps = Help::where('fond_status', 'finished')->get();
                    break;
            }
            return view('backend.admin.category-helps')->with(compact('helps','title'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    public function showFondsFromCategory($category){
        if(Auth::user()->role_id <= 2){
            switch ($category) {
                case 0:
                    $title = 'Отклонена';
                    break;
                case 1:
                    $title = 'В реестре';
                    break;
                case 2:
                    $title = 'На модерации';
                    break;
            }
            $fonds = Fond::where('status', $category)->get();
            return view('backend.admin.category-fonds')->with(compact('fonds','title'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    public function checkHelp($id){
        if(Auth::user()->role_id <= 2){
            $help = Help::whereId($id)->first();
            return view('backend.admin.help-layout')->with(compact('help'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    public function checkFond($id){
        if(Auth::user()->role_id <= 2){
            $fond = Fond::whereId($id)->first();
            return view('backend.admin.fond-layout')->with(compact('fond'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    public function editHelpStatus(Request $request){
        if(Auth::user()->role_id <= 2){
            $validator = Validator::make($request->all(),[
                'status_name' => 'required',
            ], [
                'status_name.required'=>'Не выбран вариант!',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $status_name = $request->get('status_name');
            $help = Help::whereId($request->get('help_id'))->first();

            $new_history = new History();

            // if finished
            if($status_name == 'finished'){
                $help->admin_status = $status_name;
                $help->fond_status = 'wait';
            }

            // if edit
            if($status_name == 'edit'){
                $validator = Validator::make($request->all(),[
                    'whyfordesc' => 'required|min:5',
                ], [
                    'whyfordesc.required'=>'Не указана причина отправки запроса на доработку!',
                    'whyfordesc.min'=>'Не указана причина отправки запроса на доработку!',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $new_history->desc = $request->get('whyfordesc');
                $help->admin_status = $status_name;
            }

            // if cancel
            if($status_name == 'cancel'){
                $validator = Validator::make($request->all(),[
                    'whycancel' => 'required',
                ], [
                    'whycancel.required'=>'Не указана причина для откланения запроса!',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }

                $new_history->desc = $request->get('whycancel');
                $help->admin_status = $status_name;
            }
            $new_history->admin_id = Auth::user()->id;
            $new_history->help_id = $help->id;
            $new_history->status = $status_name;

            $help->save();
            $new_history->save();

            return redirect()->route('admin_helps')->with('success', 'Статус запроса изменен!');
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    public function editFondStatus(Request $request){
        if(Auth::user()->role_id <= 2){
            $validator = Validator::make($request->all(),[
                'status_name' => 'required',
            ], [
                'status_name.required'=>'Не выбран вариант!',
            ]);
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $status_name = $request->get('status_name');
            $fond = Fond::whereId($request->get('fond_id'))->first();

            $new_history = new HistoryFond();

            // if finished
            if($status_name == 'finished'){
                $fond->status = '1';
            }

            // if cancel
            if($status_name == 'cancel'){
                $validator = Validator::make($request->all(),[
                    'whycancel' => 'required|min:5',
                ], [
                    'whycancel.required'=>'Не указана причина отправки запроса на отклонение!',
                    'whycancel.min'=>'Не указана причина отправки запроса на отклонение!',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $new_history->desc = $request->get('whycancel');
                $fond->status = '0';
            }

            $new_history->admin_id = Auth::user()->id;
            $new_history->fond_id = $fond->id;
            $new_history->status = $status_name;

            $fond->save();
            $new_history->save();

            return redirect()->route('admin_fonds')->with('success', 'Статус запроса изменен!');
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }
}
