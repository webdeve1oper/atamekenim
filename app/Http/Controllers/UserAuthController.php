<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{

    public function index()
    {
        return view('frontend.auth.login');
    }

    public function registration()
    {
        return view('frontend.auth.registration');
    }

    public function postLogin(Request $request)
    {
        if(is_numeric($request->email)){

            $validator = Validator::make($request->all(),[
                'email' => 'required|min:12|max:12',
                'password' => 'required'
            ], [
                'email.required'=>'ИИН должен содержать 12 цифр',
                'email.min'=>'ИИН должен содержать 12 символов',
                'email.max'=>'ИИН должен содержать 12 символов',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $credentials = ['iin'=>$request->email, 'password'=>$request->password];
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
            return redirect()->intended('cabinet');
        }
        return redirect()->route('login')->with('error', 'Что-то пошло не так!');
    }

    public function postRegistration(Request $request)
    {
       $validator = Validator::make($request->all(),[
            'first_name' => 'required',
            'last_name' => 'required',
            'iin' => 'required|unique:users|min:12',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
        ],[
            'first_name.required'=>'Заполните имя',
            'last_name.required'=>'Заполните фамилию',
            'iin.required'=>'Заполните ИИН',
            'password.required'=>'Введите пароль',
            'email.required'=>'Заполните почту',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $data = $request->all();

        $check = $this->create($data);
        if($check){
            return redirect()->route('login')->withSuccess('Вы успешно зарегистрированы!');
        }else{
            return redirect('back')->withErrors('Что то пошло не так! Попробуйте снова');
        }

    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function logout()
    {
        Auth::logout();
        return Redirect('/');
    }
}
