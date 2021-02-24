<?php

namespace App\Http\Controllers\Backend;

use App\BaseHelpType;
use App\Fond;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FondController extends Controller
{
    //
    public function index()
    {
        $fond = Fond::find(Auth::user()->id);

        return view('backend.fond_cabinet.index')->with(compact('fond'));
    }

    public function edit()
    {
        $baseHelpTypes = BaseHelpType::select('name_ru as text', 'id')->with('addHelpTypes')->get();

        return view('backend.fond_cabinet.edit')->with(compact('baseHelpTypes'));
    }
}
