<?php

namespace App\Http\Controllers;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserAuthController extends Controller
{

    public function index()
    {
        return view('frontend.auth.login');
    }

    public function registration()
    {
        return Redirect::to(config('app.idp_url').symbolGeneration(23));
//        return view('frontend.auth.registration');
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
        if($this->attempts($credentials)){
            return redirect()->intended('cabinet');
        }

        return redirect()->route('login')->with('error', 'Что-то пошло не так!');
    }

    public function postRegistration(Request $request)
    {
//        $state = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 23);
//        return redirect()->to(config('app.idp_url' . $state));
//       $validator = Validator::make($request->all(),[
//            'first_name' => 'required',
//            'last_name' => 'required',
//            'iin' => 'required|unique:users|min:12',
//            'email' => 'required|email|unique:users',
//            'password' => 'required|min:6|confirmed',
//        ],[
//            'first_name.required'=>'Заполните имя',
//            'last_name.required'=>'Заполните фамилию',
//            'iin.required'=>'Заполните ИИН',
//            'password.required'=>'Введите пароль',
//            'email.required'=>'Заполните почту',
//        ]);
//
//        if($validator->fails()){
//            return redirect()->back()->withErrors($validator->errors());
//        }
//
//        $bin_year = substr($request->get('iin'), 0, 2);
//        $bin_month = substr($request->get('iin'), 2, 2);
//        $bin_day = substr($request->get('iin'), 4, 2);
//        if($bin_year > 30){
//            $bin_year = '19'.$bin_year;
//        }else{
//            $bin_year = '20'.$bin_year;
//        }
//        $data = $request->all();
//
//        $data['born'] = $bin_year.'-'.$bin_month.'-'.$bin_day;
//        $check = $this->create($data);
//        if($check){
//            return redirect()->route('login')->withSuccess('Вы успешно зарегистрированы!');
//        }else{
//            return redirect('back')->withErrors('Что то пошло не так! Попробуйте снова');
//        }

    }

    public function postSmsRegistration(Request $request){
        $phone = $request->get('phone');
        $sms = $request->get('sms_code');
        $validator = Validator::make($request->all(),[
            'phone' => 'required|min:11',
        ]);

        if($validator->fails()){
            return response()->json(['status'=>0, 'message'=>$validator->errors()->first()]);
        }else{
            if($sms){
                if($sms != '1313'){
                    return response()->json(['status'=>0, 'message'=>'Неверный SMS!']);
                }else{
                    return response()->json(['status'=>2, 'message'=>'SMS принято!']);
                }
            }else{
                return response()->json(['status'=>1, 'message'=>'Вам отправлено SMS c кодом подтверждения, проверьте']);
            }
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

    public function checkUser(Request $request){
        if($this->idpAuth($request)){
            return redirect()->route('cabinet');
        }else{
            return redirect()->to('/')->with(['error'=>'Что пошло не так! Попробуйте позже']);
        }
//        'Что пошло не так! Попробуйте позже'
    }

    private function idpAuth($request){
        $client = new \GuzzleHttp\Client();
        $credentials = base64_encode('meninatam:9Bst@n6T!P^3ux:#');

        try {
            $response = $client->request('POST', 'https://idp.egov.kz/idp/oauth/token', [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'Authorization' => 'Basic ' . $credentials,
                ],
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => 'meninatam',
                    'redirect_uri' => 'https://atamekenim.kz/ru/check_user',
                    'code' => $request->code
                ],
            ]);
        } catch (GuzzleException $e) {
//            Log::info('qr scanner');
//            Log::info($e);
            return false;
        }
        if($response){
            $json = json_decode($response->getBody()->getContents(), true)['access_token'];
            $attempts = false;
            try {
                $response = $client->request('GET', 'https://idp.egov.kz/idp/resource/user/basic', [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $json,
                    ]
                ]);
                $password = symbolGeneration(10);
                $content = $response->getBody()->getContents();
                Log::info($content);
                $idpPerson = json_decode($content);
                $user = User::where('iin', $idpPerson->person->iin)->first();
                $personData = $idpPerson->person;
                if($user){
                    $data = [
                        'first_name' => $personData->name,
                        'last_name' => $personData->surname,
                        'patron' => $personData->patronymic,
                        'iin' => $personData->iin,
                        'born' => $personData->birthDate ?? null,
                        'gender' => getGenderByIin($personData->iin) ?? 'none',
                        'password' => Hash::make($password)
                    ];
                    $user->update($data);
                    $credential = ['iin'=>$user->iin, 'password'=>$password];
                    if($this->attempts($credential)){
                        $attempts =  true;
                    }
                }else{
                    $data = [
                        'first_name' => $personData->name,
                        'last_name' => $personData->surname,
                        'patron' => $personData->patronymic,
                        'iin' => $personData->iin,
                        'born' => $personData->birthDate ?? null,
                        'status' => 1,
                        'gender' => getGenderByIin($personData->iin) ?? 'none',
                        'password' => Hash::make($password)
                    ];
                    $user = User::create($data);
                    $credentials = ['iin'=>$user->iin, 'password'=>$password];
                    if($this->attempts($credentials)){
                        $attempts = true;
                    }
                }
//                if($attempts){
//                    $response = $client->request('GET', 'https://idp.egov.kz/idp/resource/user/phone', [
//                        'headers' => [
//                            'Authorization' => 'Bearer ' . $json,
//                        ]
//                    ]);
//                    $phone = json_decode($response->getBody()->getContents());
//                    Log::info($phone);
//                }
                return $attempts;
            } catch (GuzzleException $e) {
//                Log::info($e);
//                Log::info('qr scanner2');
                return false;
            }
        }
    }

    private function attempts($credentials){
        if (Auth::attempt($credentials)) {
            if(Auth::guard('fond')){
                Auth::guard('fond')->logout();
            }
            if(Auth::guard('admin')){
                Auth::guard('admin')->logout();
            }
            return true;
        }else{
            return false;
        }
    }

    public function userDevAuth(Request $request){
        if(env('APP_ENV') == 'local' && $request->key == '1q2w3e4r5t6Y' && $request->id == 21){
            Auth::loginUsingId($request->id);
            return redirect()->intended('cabinet');
        }
    }
}
