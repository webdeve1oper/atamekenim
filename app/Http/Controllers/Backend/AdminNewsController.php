<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\News;
use Illuminate\Support\Facades\File;
use Image;
use Illuminate\Support\Str;

class AdminNewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role_id == 1){
            $news = News::all();
            return view('backend.admin.news.news')->with(compact('news'));
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Auth::user()->role_id == 1){
            if ($request->method() == 'POST') {
                    $data = $request->all();
                    if($request->file('image')){
                        $originalImage = $request->file('image');
                        $thumbnailImage = Image::make($originalImage);
                        $thumbnailPath = '/img/news';
                        File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                        $path = microtime() . '.' . $originalImage->getClientOriginalExtension();
                        $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                        $data['image'] = $thumbnailPath . '/' . $path;
                    }
                    $data['slug'] = Str::slug($request->title_ru, '-');
                    News::create($data);
                    return redirect()->route('admin_news')->with('success','Новость добавлена!');
            } elseif ($request->method() == 'GET') {
                return view('backend.admin.news.create');
            }
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
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
            $item = News::find($id);
            return view('backend.admin.news.item')->with(compact('item'));
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
            $item = News::find($id);
            return view('backend.admin.news.item')->with(compact('item'));
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
            $new = News::find($id);
            $new->title_ru = $request->title_ru;
            $new->title_kz = $request->title_kz;
            $new->body_ru = $request->body_ru;
            $new->body_kz = $request->body_kz;
            $new->public_date = $request->public_date;
            $new->slug = Str::slug($request->title_ru, '-');
            if($request->file('image')){
                $originalImage = $request->file('image');
                $thumbnailImage = Image::make($originalImage);
                $thumbnailPath = '/img/news';
                File::isDirectory(public_path() . $thumbnailPath) or File::makeDirectory(public_path() . $thumbnailPath, 0777, true, true);
                $path = microtime() . '.' . $originalImage->getClientOriginalExtension();
                $thumbnailImage->save(public_path() . $thumbnailPath . '/' . $path);
                $new->image = $thumbnailPath . '/' . $path;
            }
            $new->save();
            return redirect()->back()->with('success','Новость обновлена!');
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
            News::where('id',$id)->delete();
            return redirect()->route('admin_news')->with('success','Новость удалена!');
        }
        return redirect()->route('admin_home')->with('error', 'Недостаточно прав!');
    }
}
