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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //

    public function index()
    {
        return view('backend.admin.home');
    }

    public function showHelps(){
        $helps1 = null;
        $helps2 = null;
        $helps3 = null;
        $helps4 = null;
        $helps5 = null;
        $helps6 = null;
        $helps7 = null;
        $helps8 = null;
        $helps9 = null;
        $helps10 = null;
        if(in_array(Auth::user()->role_id, [1,2,3])){
            if(is_operator() or is_admin()){
                $helps1 = Help::where('admin_status','moderate')->count();
                $helps2 = Help::where('admin_status','finished')->where('fond_status', 'wait')->count();
                $helps3 = Help::where('fond_status','process')->count();
                $helps4 = Help::where('admin_status','cancel')->count();
                $helps5 = Help::where('admin_status','edit')->count();
                $helps6 = Help::where('fond_status','finished')->count();
                try{
                    $helps7 = Help::where('helps.admin_status', 'moderate')
                        ->join('help_addhelptypes', 'helps.id', '=', 'help_addhelptypes.help_id')
                        ->where('help_addhelptypes.add_help_id', '=', 1)->count();
                }catch (\Exception $exception){
                }
                try{
                    $helps8 = Help::where('helps.admin_status', 'finished')
                        ->join('help_addhelptypes', 'helps.id', '=', 'help_addhelptypes.help_id')
                        ->where('help_addhelptypes.add_help_id', '=', 1)->count();
                }catch (\Exception $exception){
                }
            }
            if (is_moderator() or is_admin()){
                $helps9 = Help::getPossibleKHhelps()->count();
                $helps10 = Help::getApprovedKHhelps()->count();
            }

            return view('backend.admin.helps')->with(compact('helps1','helps2','helps3','helps4','helps5','helps6','helps7','helps8', 'helps9', 'helps10'));
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

    public function showHelpsFromCategory($category, Request $request){
        $helps = Help::query();
        if(isset($request->id)){
            if($request->id != ''){
                $helps = $helps->whereId($request->id);
            }
        }
        if(Auth::user()->role_id <= 2){
            switch ($category) {
                case 'moderate':
                    $title = 'На модерации';
                    $helps = $helps->where('admin_status', $category)->paginate(8);
                    break;
                case 'health':
                    $title = 'На модерации / Здоровье';
                    try{
                        $helps = $helps->where('helps.admin_status', 'moderate')
                            ->join('help_addhelptypes', 'helps.id', '=', 'help_addhelptypes.help_id')
                            ->where('help_addhelptypes.add_help_id', '=', 1)->paginate(8);
                    }catch (\Exception $exception){
                    }
                    break;
                case 'health-moderated':
                    $title = 'Прошли модерацию / Здоровье';
                    try{
                        $helps = $helps->where('helps.admin_status', 'finished')
                            ->join('help_addhelptypes', 'helps.id', '=', 'help_addhelptypes.help_id')
                            ->where('help_addhelptypes.add_help_id', '=', 1)->paginate(8);
                    }catch (\Exception $exception){
                    }
                    break;
                case 'finished':
                    $title = 'В ожидании благотворителя';
                    $helps = $helps->where('admin_status', $category)->where('fond_status', 'wait')->paginate(8);
                    break;
                case 'fond_process':
                    $title = 'В работе';
                    $helps = $helps->where('fond_status', 'process')->paginate(8);
                    break;
                case 'cancel':
                    $title = 'Отклонена';
                    $helps = $helps->where('admin_status', $category)->paginate(8);
                    break;
                case 'edit':
                    $title = 'Требует правок';
                    $helps = $helps->where('admin_status', $category)->paginate(8);
                    break;
                case 'fond_finished':
                    $title = 'Исполнена';
                    $helps = $helps->where('fond_status', 'finished')->paginate(8);
                    break;
            }
            return view('backend.admin.category-helps')->with(compact('helps','title'));
        }elseif (is_moderator()){
            switch ($category) {
                case 'moderate':
                    $title = 'На модерации';
                    $helps = $helps->where('admin_status','finished')->where('status_kh',Help::STATUS_KH_POSSIBLY)->paginate(8);
                    break;
                case 'health':
                    $title = 'На модерации / Здоровье';
                    try{
                        $helps = $helps->where('helps.admin_status', 'moderate')
                            ->join('help_addhelptypes', 'helps.id', '=', 'help_addhelptypes.help_id')
                            ->where('help_addhelptypes.add_help_id', '=', 1)->paginate(8);
                    }catch (\Exception $exception){
                    }
                    break;
                case 'health-moderated':
                    $title = 'Прошли модерацию / Здоровье';
                    try{
                        $helps = $helps->where('helps.admin_status', 'finished')
                            ->join('help_addhelptypes', 'helps.id', '=', 'help_addhelptypes.help_id')
                            ->where('help_addhelptypes.add_help_id', '=', 1)->paginate(8);
                    }catch (\Exception $exception){
                    }
                    break;
                case 'finished':
                    $title = 'В ожидании благотворителя';
                    $helps = $helps->where('admin_status', $category)->where('fond_status', 'wait')->where('status_kh',Help::STATUS_KH_APPROVED)->paginate(8);
                    break;
                case 'fond_process':
                    $title = 'В работе';
                    $helps = $helps->where('fond_status', 'process')->paginate(8);
                    break;
                case 'cancel':
                    $title = 'Отклонена';
                    $helps = $helps->where('admin_status', $category)->paginate(8);
                    break;
                case 'edit':
                    $title = 'Требует правок';
                    $helps = $helps->where('admin_status', $category)->paginate(8);
                    break;
                case 'fond_finished':
                    $title = 'Исполнена';
                    $helps = $helps->where('fond_status', 'finished')->paginate(8);
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
        if(Auth::user()->role_id <= 3){
            $help = Help::whereId($id)->first();
            return view('backend.admin.help-layout')->with(compact('help'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    public function editHelpBodyFromAdmin(Request $request, $id){
        if(Auth::user()->role_id <= 2){
            $help = Help::whereId($id)->first();
            $help->body = $request->help_body;
            $help->save();
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
        if(Auth::user()->role_id <= 3){
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
                    'whyedit' => 'required',
                ], [
                    'whyedit.required'=>'Не указана причина отправки запроса на доработку!',
                ]);
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput();
                }
                $new_history->desc = $request->get('whyedit').', '.$request->get('comment_edit');
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

                $new_history->desc = $request->get('whycancel').', '.$request->get('comment_cancel');
                $help->admin_status = $status_name;
            }

            //if possible kh
            if($status_name == 'kh'){
                $help->admin_status = 'finished';
                $help->fond_status = 'moderate';
                $help->status_kh = Help::STATUS_KH_POSSIBLY;
            }

            //if possible kh
            if($status_name == 'kh_approved'){
                $help->admin_status = 'finished';
                $help->fond_status = 'wait';
                $help->status_kh = Help::STATUS_KH_APPROVED;
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
