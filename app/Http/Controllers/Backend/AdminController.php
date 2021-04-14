<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Help;
use App\History;
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
            $helps = Help::all();
            return view('backend.admin.helps')->with(compact('helps'));
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
}
