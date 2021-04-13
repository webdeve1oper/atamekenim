<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Help;
use App\History;
use App\Admin;
use App\Role;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role_id == 1){
            $admins = Admin::all();
            return view('backend.admin.admins')->with(compact('admins'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->role_id == 1){
            $admin = Admin::find($id);
            return view('backend.admin.admin-layout')->with(compact('admin'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->role_id == 1){
            $admin = Admin::find($id);
            $roles = Role::all();
            return view('backend.admin.admin-layout')->with(compact('admin','roles'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->role_id == 1){
            Admin::whereId($id)->update($request->except(['_token']));
            return redirect()->back()->with('success','Данные обновлены!');
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role_id == 1){
            Admin::where('id',$id)->delete();
            return redirect()->route('admins')->with('success','Пользователь удален!');
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }
}
