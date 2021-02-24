<?php

namespace App\Http\Controllers\Frontend;

use App\Fond;
use App\Http\Controllers\Controller;
use App\News;
use Illuminate\Http\Request;

class MainController extends Controller
{
    //
    public function index(){
        $fonds = Fond::all();
        $newFonds = Fond::orderBy('created_at')->get();
        $news = News::orderBy('public_date', 'desc')->limit(10)->get();
        return view('frontend.home')->with(compact('fonds', 'news', 'newFonds'));
    }



    public function new($slug){
        $new = News::whereSlug($slug)->first();

        return view('frontend.new')->with(compact('new'));
    }

    public function news(){
        $news = News::all();

        return view('frontend.news')->with(compact('news'));
    }
}
