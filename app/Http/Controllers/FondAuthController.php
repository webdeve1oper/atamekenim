<?php

namespace App\Http\Controllers;

use App\Fond;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FondAuthController extends Controller
{
    use AuthenticatesUsers;


    public function index()
    {
        return view('frontend.auth.login');
    }

    public function registration()
    {
        return view('frontend.auth.fond_registration');
    }

    public function postLogin(Request $request)
    {
        if(is_numeric($request->email)){

            $validator = Validator::make($request->all(),[
                'email' => 'required|min:12|max:12',
                'password' => 'required'
            ], [
                'email.required'=>'БИН должен содержать 12 цифр',
                'email.min'=>'БИН должен содержать 12 символов',
                'email.max'=>'БИН должен содержать 12 символов',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $credentials = ['bin'=>$request->email, 'password'=>$request->password];
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

        if(Auth::guard('fond')->attempt($credentials)){
            return redirect()->route('fond_cabinet');
        }
        return redirect()->route('login')->with('error', 'Что-то пошло не так!');
    }

    public function postRegistration(Request $request)
    {
        Validator::extend('phone_number', function($attribute, $value, $parameters)
        {
            return is_numeric(str_replace(['+','(',')', ' '], ['','','', ''], $value));
        });

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'bin' => 'required|unique:fonds|min:12',
            'email' => 'required|email|unique:fonds',
            'phone' => 'required|unique:fonds|phone_number',
            'password' => 'required|min:6|confirmed',
        ], [
            'title.required'=>'Заполните название организации',
            'email.required'=>'Укажите почту',
            'bin.required'=>'Заполните БИН',
            'phone.required'=>'Заполните БИН',
            'password.required'=>'Введите пароль',
            'email.email'=>'Укажите настояшую почту',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $data = $request->all();
        $data['phone'] = str_replace(['+','(',')', ' '], ['','','',''], $data['phone']);
        $check = $this->create($data);
        if($check){
            return redirect()->route('login')->withSuccess('Вы успешно зарегистрированы!');
        }else{
            return redirect()->back()->withErrors('Что то пошло не так! Попробуйте снова');
        }
    }

    public function dashboard()
    {
        if (Auth::check()) {
            return view('dashboard');
        }
        return redirect()->route("login")->withSuccess('Opps! You do not have access');
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return Fond::create($data);
    }

    public function logout()
    {
        Auth::guard('fond')->logout();
        return redirect()->route('login');
    }
}
