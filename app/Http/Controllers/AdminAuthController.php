<?php

namespace App\Http\Controllers;

use App\Help;
use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Admin;
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

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:150',
            'password' => 'required'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin_home');
        }
        return redirect()->route('admin_login')->with('error', 'Что-то пошло не так!');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return Redirect('/');
    }
}
