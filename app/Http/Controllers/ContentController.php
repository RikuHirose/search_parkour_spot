<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Content;
use Illuminate\Support\Facades\Auth;
use App\Photo;
use App\Tag;
use App\User;
use Storage;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->except('index','show', 'getroute', 'searchSpot', 'top', 'searchPlace', 'searchTag');

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

        // if(count($request->file('files')) >= 5){
        //     return redirect('')
        // }
        $this->validate($request,Content::$rules);

        // 正規表現でtagとcommentを分ける
        $str = $request->comment;
        preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);
        // preg_match_all('/[＃＃]([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);

        // tagidの検索and生成して、tagのidを取得
        $tags = array();
        foreach($match[1] as $tag) {
            $found = Tag::firstOrCreate(['tag_name' => $tag]);

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

        // 画像の保存 s3
        foreach ($request->file('files') as $index) {
                // $ext = $e['photo']->guessExtension();
                // $filename = "{$request->spot_name}_{$index}.{$ext}";

                // $path = $e['photo']->storeAs('photos', $filename);
                // photosメソッドにより、商品に紐付けられた画像を保存する
                // $content->photos()->create(['path'=> $path]);

                // $filename = $request->file('avatar_name');
            $filename = $index['photo'];
            $path = Storage::disk('s3')->putFile('pklinks', $filename, 'public');

            $url = Storage::disk('s3')->url($path);

            $content->photos()->create(['path'=> $url]);

                // $user = User::find(auth()->id());
                // $user->avatar_name = basename($url);
                // $user->save();
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
        // $content = Content::find($id);
        $content = Content::findOrFail($id); // findOrFail 見つからなかった時の例外処理
        if(Auth::check()) {
            $like = $content->likes()->where('user_id', Auth::user()->id)->first();
        } else {
            $like = '';
        }

        $tags = $content->tags;

        $content = json_decode(json_encode($content), true);
        $tags = json_decode(json_encode($tags), true);
        $img = self::getPhotos($content['id']);
        $user = self::getUserInfo($content['user_id']);


        // show/idの周辺スポット
        $lat = $content['lat'];
        $lng = $content['lng'];

        $around = Content::whereBetween('lat',[$lat - 25.5,$lat + 25.5])->whereBetween('lng',[$lng - 25.5,$lng + 25.5])->whereNotIn('id', [$id])->get();

        $around = array_map(function($v) use ($lat, $lng){
            $str = $v['comment'];
            preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);

            return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'spot_name' => $v['spot_name'],
                'address' => $v['address'],
                'tags' => $match[0],
                'diastance' => self::getDistance($lat, $lng, $v['lat'], $v['lng']),
                'user' => self::getUserInfo($v['user_id']),
            ];
        }, $around->toArray());

        // ソート用の配列を用意
        // var_dump($around);die;
        if(empty($around)) {
            $around = '';
        } else {
            foreach ($around as $key => $value) {
              $sort[$key] = $value['diastance'];
            }
            array_multisort($sort, SORT_ASC, $around);
        }


        return view('content.show' ,['content' => $content, 'img' => $img, 'around' => $around, 'tags' => $tags, 'like' =>$like, 'user' => $user]);
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
        return redirect('/');
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

    public function searchTag(Request $request)
    {
        $q  = \Request::get('q');

        $content = Content::tagFilter($q)->SearchAddress($q)->SearchSpotName($q)->get();
        $content = Content::tagFilter($q)->get();

        $content = array_map(function($v){
            $str = $v['comment'];
            preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);
            return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'spot_name' => $v['spot_name'],
                'address' => $v['address'],
                'tags' => $match[0],
                'user' => self::getUserInfo($v['user_id']),
                'likes_count' => $v['likes_count'],
                'lat' => $v['lat'],
                'lng' => $v['lng'],
            ];
        }, $content->toArray());

        $content_location = array_map(function($v){
            return [
                'id' => $v['id'],
                'lat' => $v['lat'],
                'lng' => $v['lng'],
            ];
        }, $content);

        // popular user
        $user = User::get();
        $popular_user = array_map(function($v){
            $contents = Content::where('user_id', $v['id'])->get();
            $num = count($contents);
            return [
                'id' => $v['id'],
                'name' => $v['name'],
                'comment' => $v['comment'],
                'avatar_name' => $v['avatar_name'],
                'content_count' => $num,
            ];

        },$user->toArray());
        // 投稿が多い順にソート
        foreach ((array) $popular_user as $key => $value) {
            $sort[$key] = $value['content_count'];
        }

        array_multisort($sort, SORT_DESC, $popular_user);
        $popular_user = array_slice($popular_user, 0, 5);


        return view('content.searchresultByTag', ['content' => $content, 'query' => $q, 'content_location' => $content_location, 'users' => $popular_user]);
    }

    public function searchPlace(Request $request)
    {

        // $requestで緯度経度を撮りたい
        $q  = \Request::get('q');
        $content = $request->toArray();

        $lat = $content['lat'];
        $lng = $content['lng'];
        $place = $content['q'];


        if($lat != null && $lng != null || $lat != '' && $lng != '') {
            $content = Content::whereBetween('lat',[$lat - 1.5,$lat + 1.5])->whereBetween('lng',[$lng - 1.5,$lng + 1.5])->get();

            $content = array_map(function($v) use ($lat, $lng){
                $str = $v['comment'];
                preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);

                return [
                    'img' => self::getPhotos($v['id']),
                    'id' => $v['id'],
                    'spot_name' => $v['spot_name'],
                    'address' => $v['address'],
                    'tags' => $match[0],
                    'diastance' => self::getDistance($lat, $lng, $v['lat'], $v['lng']),
                    'lat' => $v['lat'],
                    'lng' => $v['lng'],
                    'user' => self::getUserInfo($v['user_id']),
                    'likes_count' => $v['likes_count'],
                ];
            }, $content->toArray());

            $searchLocation = ['lat' => $lat, 'lng' => $lng];

            $sort = array();
            // ソート用の配列を用意
            foreach ($content as $key => $value) {
              $sort[$key] = $value['diastance'];
            }
            array_multisort($sort, SORT_ASC, $content);

            $content_location = array_map(function($v){
                return [
                    'id' => $v['id'],
                    'lat' => $v['lat'],
                    'lng' => $v['lng'],
                ];
            }, $content);

            // popular user
            $user = User::get();
            $popular_user = array_map(function($v){
                $contents = Content::where('user_id', $v['id'])->get();
                $num = count($contents);
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'comment' => $v['comment'],
                    'avatar_name' => $v['avatar_name'],
                    'content_count' => $num,
                ];

            },$user->toArray());


            // 投稿が多い順にソート
            $popsort = array();
            foreach ((array) $popular_user as $key => $value) {
                $popsort[$key] = $value['content_count'];
            }

            // array_multisort($sort, SORT_DESC, $popular_user);
            $popular_user = array_slice($popular_user, 0, 5);


            return view('content.searchresultByPlace', ['content' => $content, 'query' => $q, 'content_location' => $content_location, 'searchLocation' => $searchLocation, 'users' => $popular_user]);

        } elseif($lat === null && $lng === null || $lat === '' && $lng === '') {
            // // 呼び出しのタイミング？
            // $latlng  = \App\Helpers\Helper::get_gps_from_address($place);

            // // var_dump($latlng);die;
            // $content = Content::whereBetween('lat',[$latlng['lat'] - 1.5,$latlng['lat'] + 1.5])->whereBetween('lng',[$latlng['lng'] - 1.5,$latlng['lng'] + 1.5])->get();

            // $content = array_map(function($v) use ($latlng){
            //     $str = $v['comment'];
            //     preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);

            //     return [
            //         'img' => self::getPhotos($v['id']),
            //         'id' => $v['id'],
            //         'spot_name' => $v['spot_name'],
            //         'address' => $v['address'],
            //         'tags' => $match[0],
            //         'diastance' => self::getDistance($latlng['lat'], $latlng['lng'], $v['lat'], $v['lng']),
            //         'lat' => $v['lat'],
            //         'lng' => $v['lng'],
            //         'user' => self::getUserInfo($v['user_id']),
            //         'likes_count' => $v['likes_count'],
            //     ];
            // }, $content->toArray());

            // $searchLocation = ['lat' => $latlng['lat'], 'lng' => $latlng['lng']];
            $content = Content::tagFilter($q)->get();

            $content = array_map(function($v){
                $str = $v['comment'];
                preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);
                return [
                    'img' => self::getPhotos($v['id']),
                    'id' => $v['id'],
                    'spot_name' => $v['spot_name'],
                    'address' => $v['address'],
                    'tags' => $match[0],
                    'user' => self::getUserInfo($v['user_id']),
                    'likes_count' => $v['likes_count'],
                    'lat' => $v['lat'],
                    'lng' => $v['lng'],
                ];
            }, $content->toArray());

            $content_location = array_map(function($v){
                return [
                    'id' => $v['id'],
                    'lat' => $v['lat'],
                    'lng' => $v['lng'],
                ];
            }, $content);

            // popular user
            $user = User::get();
            $popular_user = array_map(function($v){
                $contents = Content::where('user_id', $v['id'])->get();
                $num = count($contents);
                return [
                    'id' => $v['id'],
                    'name' => $v['name'],
                    'comment' => $v['comment'],
                    'avatar_name' => $v['avatar_name'],
                    'content_count' => $num,
                ];

            },$user->toArray());
            // 投稿が多い順にソート
            foreach ((array) $popular_user as $key => $value) {
                $sort[$key] = $value['content_count'];
            }

            array_multisort($sort, SORT_DESC, $popular_user);
            $popular_user = array_slice($popular_user, 0, 5);


            return view('content.searchresultByTag', ['content' => $content, 'query' => $q, 'content_location' => $content_location, 'users' => $popular_user]);
        }

        // $content = Content::whereBetween('lat',[$lat - 1.5,$lat + 1.5])->whereBetween('lng',[$lng - 1.5,$lng + 1.5])->get();

        //     $content = array_map(function($v) use ($lat, $lng){
        //         $str = $v['comment'];
        //         preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);

        //         return [
        //             'img' => self::getPhotos($v['id']),
        //             'id' => $v['id'],
        //             'spot_name' => $v['spot_name'],
        //             'address' => $v['address'],
        //             'tags' => $match[0],
        //             'diastance' => self::getDistance($lat, $lng, $v['lat'], $v['lng']),
        //             'lat' => $v['lat'],
        //             'lng' => $v['lng'],
        //             'user' => self::getUserInfo($v['user_id']),
        //             'likes_count' => $v['likes_count'],
        //         ];
        //     }, $content->toArray());

        // $searchLocation = ['lat' => $lat, 'lng' => $lng];


        // $sort = array();
        // // ソート用の配列を用意
        // foreach ($content as $key => $value) {
        //   $sort[$key] = $value['diastance'];
        // }
        // array_multisort($sort, SORT_ASC, $content);

        // $content_location = array_map(function($v){
        //     return [
        //         'id' => $v['id'],
        //         'lat' => $v['lat'],
        //         'lng' => $v['lng'],
        //     ];
        // }, $content);


        // return view('content.searchresultByPlace', ['content' => $content, 'query' => $q, 'content_location' => $content_location, 'searchLocation' => $searchLocation]);
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
                    'user' => self::getUserInfo($v['user_id']),
                ];
        }, $content->toArray());


        // ranking
        //  いいねが多い順
        $ranking = Content::orderBy('likes_count', 'desc')->get();

        $ranking = array_map(function($v){
            $str = $v['comment'];
            preg_match_all('/#([a-zA-Z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $str, $match);
            return [
                'img' => self::getPhotos($v['id']),
                'id' => $v['id'],
                'spot_name' => $v['spot_name'],
                'address' => $v['address'],
                'tags' => $match[0],
                'user' => self::getUserInfo($v['user_id']),
                'likes_count' => $v['likes_count'],
            ];
        }, $ranking->toArray());

        $ranking = array_slice($ranking, 0, 6);

        // popular user
        $user = User::get();
        $popular_user = array_map(function($v){
            $contents = Content::where('user_id', $v['id'])->get();
            $num = count($contents);
            return [
                'id' => $v['id'],
                'name' => $v['name'],
                'comment' => $v['comment'],
                'avatar_name' => $v['avatar_name'],
                'content_count' => $num,
            ];

        },$user->toArray());
        // 投稿が多い順にソート
        foreach ((array) $popular_user as $key => $value) {
            $sort[$key] = $value['content_count'];
        }

        array_multisort($sort, SORT_DESC, $popular_user);
        $popular_user = array_slice($popular_user, 0, 5);


        return view('content.top', ['content' => $content, 'ranking' => $ranking, 'users' => $popular_user]);
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

    public function getUserInfo($userid)
    {
        $user = User::all()->where('id', $userid);
        $user = $user->toArray();

        return $user;
    }

   public function getDistance($lat1, $lon1, $lat2, $lon2)
   {

        $theta = $lon1 - $lon2;
        $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $distance = $dist * 60 * 1.1515 * 1.609344;
        $distance = round($distance, 2);

        return $distance;
    }





}
