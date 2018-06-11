<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use Illuminate\Support\Facades\Auth;
// use Input;

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
        // echo $request->lat;
        // echo $request->lng;
        // echo $request->address;
        // die;
        $this->validate($request,Content::$rules);

        if ($request->file('file')->isValid([])) {
            $filename = $request->file->store('public/avatar');

            $content = new Content;
            $content->icon_name = basename($filename);
            $content->lat =  $request->lat;
            $content->lng = $request->lng;
            $content->address =  $request->address;
            $content->spot_name =  $request->spot_name;
            $content->save();

            return redirect('/')->with('success', '保存しました。');
        } else {
            return redirect()
                ->back()
                ->withErrors(['file' => '画像がアップロードされていないか不正なデータです。'])
                ->withInput();
        }
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
        return view('content.show' ,['content' => $content]);
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
        return view('content.edit' ,['content' => $content]);
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
        $this->validate($request,Content::$edit);

        if ($request->file('file')->isValid([])) {
            $filename = $request->file->store('public/avatar');

            $content = Content::find($id);
            $content->icon_name = basename($filename);
            $content->lat =  $request->lat;
            $content->lng = $request->lng;
            $content->address =  $request->address;
            $content->spot_name =  $request->spot_name;
            $content->save();

            return redirect('/')->with('success', '保存しました。');

        } else {
            return redirect()
                ->back()
                ->withInput()
                ->withErrors(['file' => '画像がアップロードされていないか不正なデータです。']);
        }

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

        $content = Content::whereBetween('lat',[$lat - 0.5,$lat + 0.5])->whereBetween('lng',[$lng - 0.5,$lng + 0.5])->get();

        return $content;
    }

    public function top()
    {

        $content = Content::all();
        return view('content.top', ['content' => $content]);
    }

    public function getEditList()
    {
        $content = Content::all();
        return view('content.editlist', ['content' => $content]);
    }



}
