<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use Illuminate\Support\Facades\Auth;
use App\Photo;
use App\Tag;

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
        $tags = Tag::pluck('tag_name','id');
        $tags = json_decode(json_encode($tags), true);

        return view('content.create', ['tags' => $tags]);
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

        // 正規表現でtagとcommentを分ける
        // this #bar spot  is a amaging spot!!このような場合どうするのか？
        $str = $request->comment;
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);

        // tagidの検索and生成して、tagのidを取得
        $tags = array();
        foreach($match[1] as $tag) {
            $found = Tag::firstOrCreate(['tag_name' => $tag]);
            // var_dump($found->tag_name);
            array_push($tags, $found);
        }

        $tagid = array();
        foreach ($tags as $k) {
            $found = $k['id'];
            array_push($tagid, $found);
        }

        // 情報の保存
        $content = Content::create(['lat' => $request->lat,'lng' => $request->lng, 'address' => $request->address, 'spot_name' => $request->spot_name, 'comment' => $request->comment, 'user_id' => $request->user_id]);
        // tag idの配列を渡し、contentに紐付いたtagを保存
        $content->tags()->attach($tagid);

        // 画像の保存
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $content = Content::find($id);
        $tags = $content->tags;

        $content = json_decode(json_encode($content), true);
        $tags = json_decode(json_encode($tags), true);


        // show/idの周辺スポット
        $lat = $content['lat'];
        $lng = $content['lng'];
        $around = Content::whereBetween('lat',[$lat - 15.5,$lat + 15.5])->whereBetween('lng',[$lng - 15.5,$lng + 15.5])->whereNotIn('id', [$id])->get();
        $around = array_map(function($v){
            $str = $v['comment'];
            preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);
        return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'spot_name' => $v['spot_name'],
                'address' => $v['address'],
                'tags' => $match[1],
            ];
        }, $around->toArray());

        $img = self::getPhotos($content['id']);
        return view('content.show' ,['content' => $content, 'img' => $img, 'around' => $around, 'tags' => $tags]);
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
        $content = Content::update(['lat' => $request->lat,'lng' => $request->lng, 'address' => $request->address, 'spot_name' => $request->spot_name]);

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

    public function top(Request $request)
    {
        // new
        $content = Content::all();

        $content = array_map(function($v){
            $str = $v['comment'];
            preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);
            return [
                    'img' => self::getPhotos($v['id']),
                    'id' => $v['id'],
                    'spot_name' => $v['spot_name'],
                    'address' => $v['address'],
                    'tags' => $match[0],
                ];
        }, $content->toArray());

        // popular
        // rating 4~5のみ
        // $popular = Content::whereBetween('rating', [4,5])->get();

        // $popular = array_map(function($v){
        // return [
        //         'img' => self::getPhotos($v['id']),
        //         'id' => $v['id'],
        //         'spot_name' => $v['spot_name']
        //     ];
        // }, $popular->toArray());


        return view('content.top', ['content' => $content]);
    }

    public function getEditList()
    {
        $content = Content::all();

        $content = array_map(function($v){
        return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'spot_name' => $v['spot_name']
            ];
        }, $content->toArray());
        return view('content.editlist', ['content' => $content]);
    }

    public function ContentsIndex()
    {
        $user_id = Auth::user()->id;
        $content = Content::where('user_id',$user_id);
        $tags = $content->tags;


        $content = json_decode(json_encode($content), true);
        $tags = json_decode(json_encode($tags), true);

        $img = self::getPhotos($content['id']);

        return view('user.index' ,['content' => $content, 'img' => $img, 'tags' => $tags, 'img' => $img]);


    }

// functions
    public function getPhotos($contentid)
    {
        $photo = Photo::all()->where('content_id',$contentid);
        $path = $photo->pluck('path')->toArray();

        return $path;
    }



}
