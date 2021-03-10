<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminAuthController extends Controller
{

    public function index()
    {
        return view('frontend.auth.admin_login');
    }

    public function postLogin(Request $request)
    {
        if(is_numeric($request->email)){

            $validator = Validator::make($request->all(),[
                'email' => 'required|min:12|max:12',
                'password' => 'required'
            ], [
                'email.required'=>'Поле должно быть заполнено',
                'password.required'=>'Поле должно быть заполнено',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $credentials = ['email'=>$request->email, 'password'=>$request->password];
        }else{

            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:150',
                'password' => 'required'
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            $request->iin = $request->email;
            $credentials = $request->only('email', 'password');
        }

        if (Auth::attempt($credentials)) {
            return redirect()->intended('admin');
        }
        return redirect()->route('admin_login')->with('error', 'Что-то пошло не так!');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return Redirect('/');
    }
}
