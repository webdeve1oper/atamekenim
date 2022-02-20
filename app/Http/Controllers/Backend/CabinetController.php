<?php

namespace App\Http\Controllers\Backend;

use App\AddHelpType;
use App\BaseHelpType;
use App\FinishedHelp;
use App\Fond;
use App\Help;
use App\HelpDoc;
use App\HelpImage;
use App\Http\Controllers\Controller;
use App\Review;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Image;
use App\Scenario;
use App\Region;
use App\Destination;
use App\CashHelpType;
use App\CashHelpSize;

class CabinetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
//        $expiresAt = Carbon::now()->addMinutes(5);
        $moderateHelps = Auth::user()->helpsByStatus('moderate')->where('admin_status', '!=','cancel')->with('fonds')->with('reviews')->get();
        $waitHelps = Auth::user()->helpsByStatus('wait')->where('admin_status', '!=','cancel')->with('fonds')->with('reviews')->get();
        $finishedHelps = Auth::user()->helpsByStatus('finished')->where('admin_status', '!=','cancel')->with('fonds')->with('reviews')->get();
        $processHelps =  Auth::user()->helpsByStatus('process')->where('admin_status', '!=','cancel')->with('fonds')->with('reviews')->get();
        $cancledHelps =  Auth::user()->helpsByStatus('cancel')->where('admin_status', 'cancel')->get();
        return view('backend.cabinet.index')->with(compact('waitHelps', 'finishedHelps', 'processHelps', 'moderateHelps', 'cancledHelps'));
    }

    public function create()
    {
        $baseHelpTypes = BaseHelpType::all();
        $addHelpTypes = AddHelpType::all();
        $fonds = Fond::all();

        return view('backend.cabinet.help.create')->with(compact('baseHelpTypes', 'addHelpTypes', 'fonds'));
    }


    public function help(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'title' => 'required|min:5',
                'body' => 'required|min:5',
                'baseHelpTypes' => 'required',
                'addHelpTypes' => 'required',
                'city_id' => 'required',
                'region_id' => 'required',
            ],
            [
                'title.required' => 'Поле обязательно для заполнения'
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        unset($data['_token']);
        $help = Help::create($data);

        $fonds = Fond::pluck('id');

        if ($fonds == count($fonds)) {
            $help->fond()->attach($fonds);
        } else {
            return redirect()->back()->with(['error' => 'Укажите хотябы один фонд']);
        }

        if (isset($data['addHelpTypes']) && count($data['addHelpTypes']) > 0) {
            $help->addHelpTypes()->attach($data['addHelpTypes']);
        }

        if ($help) {
            return redirect()->back()->with(['success' => 'Заявка успешно принята']);
        } else {
            return redirect()->back()->with(['error' => 'Что то пошло не так. Попробуйте снова']);
        }

    }

    public function review_to_fond(Request $request)
    {
        $validator = Validator::make($request->all(),
            [
                'title' => 'required|min:5',
                'body' => 'required|min:10',
            ]
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->all();
        $help = Help::findOrFail($data['help_id']);
        if ($help->fond_status != 'finished') {
            return redirect()->back()->with('error', 'Заявка еще не завершена!');
        }
        $data['user_id'] = Auth::user()->id;
        Review::create($data);
        return redirect()->back()->with('success', 'Отзыв отправлен!');
    }

    public function helpPage($id)
    {
        $help = Help::find($id);
        $finish_help = null;
        if(Auth::id() == $help->user_id){
            if($help->fond_status == 'finished'){
                $finish_help = FinishedHelp::whereHelpId($help->id)->with(['helpHelpers'=> function($q){
                    $q->with('cashHelpTypes');
                }, 'helpImages', 'cashHelpTypes', 'fond'])->first();
            }
            return view('backend.cabinet.help.help_page')->with(compact('help', 'finish_help'));
        }
        if($help->admin_status!='finished' and Auth::guard('web')->check()){
            return abort(404);
        }
        if($help->status == 'cancel'){
            return redirect()->back()->with(['error' => 'Заявка отклонена']);
        }
        return view('backend.cabinet.help.help_page')->with(compact('help'));
    }

    public function editUser()
    {
        $user = User::find(Auth::user()->id);
        return view('backend.cabinet.edit_info')->with(compact('user'));
    }

    public function updateUser(Request $request)
    {
        $user = User::find(Auth::user()->id);
        if ($request) {
            $validator = Validator::make($request->all(),
                [
                    'avatar' => 'mimes:jpeg,jpg,png|max:1000',
                    'about' =>'max:1000'
                ], [
                    'about.max'=>'максимальное количество символов 1000'
                ]
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            if ($request->file('avatar')) {
                $originalImage = $request->file('avatar');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = '/img/avatars';
                File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                $path = microtime() . '.' . $originalImage->getClientOriginalExtension();
                $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                $user->avatar = $thumbnailPath . '/' . $path;
            }
            $user->email = $request->email;
            $user->about = $request->about;
            $user->save();
            return redirect()->route('cabinet')->with(['success' => 'Личная информация успешно обновлена!']);
        } else {
            return redirect()->route('cabinet')->with(['error' => 'Что то пошло не так!']);
        }
    }

    public function editPage($id)
    {
        $help = Help::find($id);
        if($help->admin_status == 'cancel'){
            return redirect()->back()->with(['error' => 'Заявка отклонена']);
        }
        if ($help->user_id == Auth::user()->id) {
            $scenarios = Scenario::select('id', 'name_ru', 'name_kz')->with(['addHelpTypes', 'destinations'])->get()->toArray();
            $baseHelpTypes = AddHelpType::all();
            $regions = Region::select('region_id', 'title_ru as text')->with('districts.cities')->get();
            $destinations = Destination::all();
            $cashHelpTypes = CashHelpType::all();
            $cashHelpSizes = CashHelpSize::all();
            return view('frontend.fond.request_help')->with(compact('help', 'scenarios', 'baseHelpTypes', 'regions', 'destinations', 'cashHelpTypes', 'cashHelpSizes'));
        } else {
            return redirect()->route('cabinet')->with(['error' => 'Это заявка не пренадлежит Вам!']);
        }
    }

    public function updateHelp(Request $request, $help_id)
    {
//        $validator = Validator::make($request->all(),
//            [
//                'body'=>'required|min:5',
//                'baseHelpTypes'=>'required',
//                'addHelpTypes'=>'required',
//                'city_id'=>'required',
//                'region_id'=>'required',
//            ],
//            [
//                'title.required'=>'Поле обязательно для заполнения'
//            ]
//        );
//        if($validator->fails()){
//            return redirect()->back()->withErrors($validator->errors());
//        }

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['admin_status'] = "moderate";
        $data['fond_status'] = "moderate";
        unset($data['_token']);
        $help = Help::whereId($help_id)->first();
        $fonds = Fond::pluck('id');
        if (isset($request->destinations) && !empty($request->destinations)) {
            $help->destinations()->sync($request->destinations);
        }
        if (isset($request->baseHelpTypes) && !empty($request->baseHelpTypes)) {
            $help->addHelpTypes()->sync($request->baseHelpTypes);
        }
        if (isset($request->cashHelpTypes) && !empty($request->cashHelpTypes)) {
            $help->cashHelpTypes()->sync($request->cashHelpTypes);
        }
        $validator = validator::make($request->all(), [
            'photo.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ], [
            'photo.max'=>'Размер фото не должен превышать 2мб'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $image) {
                $filename = microtime() . $help->id . '.' . $image->getClientOriginalExtension();
                $thumbnailImage = \Intervention\Image\Facades\Image::make($image);
                $path = '/img/help/' . $filename;
                $thumbnailImage->resize(700, null)->save(public_path() . $path);
                HelpImage::create(['help_id' => $help->id, 'image' => $path]);
            }
        }
        $validator = validator::make($request->all(), [
            'doc.*' => 'mimes:jpeg,png,jpg,doc,pdf,docx,xls,xlx,xlsx,txt|max:5000'
        ], [
            'doc.max'=>'Размер файла не может превышать 5мб'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->with('error', $validator->errors());
        }
        if ($request->hasFile('doc')) {
            foreach ($request->file('doc') as $doc) {
                $filename = microtime() . $help->id . '.' . $doc->getClientOriginalExtension();
                $path = '/img/help/docs/';
                $doc->move(public_path() . $path, $filename);
                HelpDoc::create(['help_id' => $help->id, 'path' => $path . $filename, 'original_name' => $doc->getClientOriginalName()]);
            }
        }
        $help->fonds()->sync($fonds);
        $help->update($data);
        return redirect()->back()->with(['success' => 'Ваша заявка усешно обновлена!']);
    }

    public function deleteImage(Request $request)
    {
        $image = HelpImage::find($request->id);
        \File::delete(public_path($image->image));
        $image->delete();
        return 'success';
    }

    public function deleteFile(Request $request)
    {
        $file = HelpDoc::find($request->id);
        \File::delete(public_path($file->path));
        $file->delete();
        return 'success';
    }
}
