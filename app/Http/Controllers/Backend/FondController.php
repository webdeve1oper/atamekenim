<?php

namespace App\Http\Controllers\Backend;

use App\BaseHelpType;
use App\Fond;
use App\Help;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Image;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class FondController extends Controller
{
    //
    public function index()
    {
        $fond = Fond::find(Auth::user()->id);

        return view('backend.fond_cabinet.index')->with(compact('fond'));
    }

    public function start_help($id){
        if(Auth::user()->helps->contains($id)){
            $help = Help::find($id);
            $help->status = 'process';
            $help->date_fond_start = Carbon::today();
            if(DB::table('help_fond')->whereHelpId($id)->whereFondStatus('enable')->first()){
                return redirect()->back()->with('error', 'Заявка уже принята другим фондом');
            }
            DB::table('help_fond')->update(['fond_status'=>'enable']);

            $help->save();
            return redirect()->back()->with('success', 'Успех');
        }else{
            return redirect()->back()->with('error', 'Заявка уже принята');
        }
    }

    public function finish_help($id){
        if(Auth::user()->helps->contains($id)){
            $help = Help::find($id);
            $help->status = 'finished';
            $help->date_fond_finish = Carbon::today();
            $help->save();
            return redirect()->back()->with('success', 'Успех');
        }else{
            return redirect()->back()->with('error', 'Заявка уже принята');
        }
    }


    // edit Fund
    public function edit()
    {
        $baseHelpTypes = BaseHelpType::with('addHelpTypes')->get()->toArray();
//        dd($baseHelpTypes);
        return view('backend.fond_cabinet.edit')->with(compact('baseHelpTypes'));
    }

    public function update(Request $request){
        if($request->method() == 'POST'){
            $validator = Validator::make($request->all(),
                [
                    'title'=>'required|min:10',
                    'image'=>'mimes:jpeg,jpg,png|max:10000',
                    'requisites'=>'required'
                ]
            );
            if($validator->fails()){
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $requisites = [];
            foreach($request->requisites as $requisite){
                array_push($requisites, ['body'=>$requisite]);
            }

            $offices = [];
            foreach($request->offices as $requisite){
                array_push($offices, ['body'=>$requisite]);
            }

            $affilates = [];
            foreach($request->affilates as $requisite){
                array_push($affilates, ['body'=>$requisite]);
            }

            $data = $request->all();
            $data['requisites'] = json_encode($requisites, JSON_UNESCAPED_UNICODE);
            $data['offices'] = json_encode($requisites, JSON_UNESCAPED_UNICODE);
            unset($data['bin']);
            $fond = Fond::find(Auth::user()->id);

            if($request->file('logo')){
                $originalImage = $request->file('logo');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = public_path().'/img/fonds/';
                $path = time().'.'.$originalImage->getClientOriginalExtension();
                $thumbnailImage->save($thumbnailPath.$path);
                $data['logo'] = '/img/fonds/'.$path;
            }else{
                unset($data['logo']);
            }

            $fond->update($data);
            return redirect()->back();


        }else{
            return redirect()->back();
        }
    }
}
