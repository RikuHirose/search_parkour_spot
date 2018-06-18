<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use Illuminate\Support\Facades\Auth;
use App\Photo;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except('index','show', 'getroute', 'searchSpot', 'top');
    }
    public function index()
    {
        $user = Auth::user();

        // new  popular area
        $content = Content::all();
        return view('content.index',compact('content','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('content.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,Content::$rules);

        // 商品情報の保存
        $content = Content::create(['lat' => $request->lat,'lng' => $request->lng, 'address' => $request->address, 'spot_name' => $request->spot_name,'rating' => $request->rating]);

        // 商品画像の保存
        foreach ($request->file('files') as $index=> $e) {
                $ext = $e['photo']->guessExtension();
                $filename = "{$request->spot_name}_{$index}.{$ext}";
                $path = $e['photo']->storeAs('photos', $filename);
                // photosメソッドにより、商品に紐付けられた画像を保存する
                $content->photos()->create(['path'=> $path]);
        }

        return redirect('/')->with(['success'=> '保存しました！']);

        // if ($request->file('file')->isValid([])) {
        //     $filename = $request->file->store('public/avatar');

        //     $content = new Content;
        //     $content->icon_name = basename($filename);
        //     $content->lat =  $request->lat;
        //     $content->lng = $request->lng;
        //     $content->address =  $request->address;
        //     $content->spot_name =  $request->spot_name;
        //     $content->rating =  $request->rating;
        //     $content->save();

        //     return redirect('/')->with('success', '保存しました。');
        // } else {
        //     return redirect()
        //         ->back()
        //         ->withErrors(['file' => '画像がアップロードされていないか不正なデータです。'])
        //         ->withInput();
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = Content::find($id);
        $content = json_decode(json_encode($content), true);
        $img = self::getPhotos($content['id']);
        return view('content.show' ,['content' => $content, 'img' => $img]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function edit($id)
    {
        $content = Content::find($id);
        $content = json_decode(json_encode($content), true);
        $img = self::getPhotos($content['id']);
        return view('content.edit' ,['content' => $content, 'img' => $img]);
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
        $this->validate($request,Content::$rules);

        $content = Content::find($id);
         // 商品情報の保存
        $content = Content::update(['lat' => $request->lat,'lng' => $request->lng, 'address' => $request->address, 'spot_name' => $request->spot_name,'rating' => $request->rating]);

        // 商品画像の保存
        foreach ($request->file('files') as $index=> $e) {
                $ext = $e['photo']->guessExtension();
                $filename = "{$request->spot_name}_{$index}.{$ext}";
                $path = $e['photo']->storeAs('photos', $filename);
                // photosメソッドにより、商品に紐付けられた画像を保存する
                $content->photos()->create(['path'=> $path]);
        }

        return redirect('/')->with(['success'=> '保存しました！']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        Content::find($id)->delete();
        return redirect('/content/id/editlist');
    }

    public function getroute($id)
    {
        $content = Content::find($id);
        return view('content.route',['content' => $content]);
    }

    public function searchSpot(Request $request)
    {
        $lat = $request->lat;
        $lng = $request->lng;
        // $content = Content::whereBetween('lat',[$lat - 312.5,$lat + 312.5])->whereBetween('lng',[$lng - 312.5,$lng + 312.5])->get();
        $content = Content::all();

        return $content;
    }

    public function top()
    {
        // new
        $content = Content::all();
        $content = array_map(function($v){
        return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'spot_name' => $v['spot_name'],
                'rating' => $v['rating']
            ];
        }, $content->toArray());

        // popular
        // rating 4~5のみ
        $popular = Content::whereBetween('rating', [4,5])->get();

        $popular = array_map(function($v){
        return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'spot_name' => $v['spot_name'],
                'rating' => $v['rating']
            ];
        }, $popular->toArray());

        // area 現在地から10kn県内
        // $content = Content::whereBetween('lat',[$lat - 0.1,$lat + 0.1])->whereBetween('lng',[$lng - 0.1,$lng + 0.1])->get();


        return view('content.top', ['content' => $content, 'popular' => $popular]);
    }

    public function getEditList()
    {
        $content = Content::all();

        $content = array_map(function($v){
        return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'spot_name' => $v['spot_name'],
                'rating' => $v['rating']
            ];
        }, $content->toArray());
        return view('content.editlist', ['content' => $content]);
    }

// functions
    public function getPhotos($contentid)
    {
        $photo = Photo::all()->where('content_id',$contentid);
        $path = $photo->pluck('path')->toArray();

        return $path;
    }



}
