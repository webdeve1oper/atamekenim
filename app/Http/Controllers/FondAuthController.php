<?php

namespace App\Http\Controllers;

use App\Fond;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\OrganLegalForm;

class FondAuthController extends Controller
{
    use AuthenticatesUsers;


    public function index()
    {
        return view('frontend.auth.fond_login');
    }

    public function registration()
    {
        $organ_legal = OrganLegalForm::all();
        return view('frontend.auth.fond_registration')->with(compact('organ_legal'));;
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
            'title_ru' => 'required',
            'bin' => 'required|unique:fonds|min:12',
            'email' => 'required|email|unique:fonds',
            'phone' => 'required|unique:fonds|phone_number',
            'fio' => 'required',
            'work' => 'required',
            'password' => 'required|min:6|confirmed',
        ], [
            'title_ru.required'=>'Заполните название организации',
            'email.required'=>'Укажите почту',
            'fio.required'=>'Заполните (ФИО сотрудника организации)',
            'work.required'=>'Заполните (Должность сотрудника организации)',
            'bin.required'=>'Заполните БИН',
            'phone.required'=>'Заполните БИН',
            'password.required'=>'Введите пароль',
            'email.email'=>'Укажите настояшую почту',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator->errors());
        }

        $bin_year = substr($request->get('bin'), 0, 2);
        $bin_month = substr($request->get('bin'), 2, 2);
        if($bin_year > 40){
            $bin_year = '19'.$bin_year;
        }else{
            $bin_year = '20'.$bin_year;
        }
        $data = $request->all();
        $data['status'] = '1';
        $data['foundation_date'] = $bin_year.'-'.$bin_month.'-01';
        $data['phone'] = str_replace(['+','(',')', ' '], ['','','',''], $data['phone']);
        $check = $this->create($data);
        if($check){
            return redirect()->route('login-fond')->withSuccess('Вы успешно зарегистрированы!');
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
