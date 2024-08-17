<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Intervention\Image\Laravel\Facades\Image;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //DBから最新のポストを取得する
        $posts = DB::table('users')->join('posts', "users.id", "=", "posts.user_id")
                    ->select("users.name", "users.icon_path", "posts.id", "posts.post", "posts.image_path", "posts.created_at")
                    ->orderBy("created_at", "DESC")
                    ->limit(50)
                    ->get();


        return view('time_line', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post_form');
    }

    /**
     * ポストフォームに入力された内容をDBに登録します
     */
    public function store(Request $request)
    {
        //バリデーションチェック
        $request->validate([
            "post" => "required|max:500",
            "post_image" => "nullable|image|mimes:jpeg,jpg,png,gif|max: 10000"
        ],[
            "post.required" => "ポストは文字入力が必須です",
            "post.max" => "ポストは500字以内で入力して下さい",
            "post_image.image" => "画像はjpeg・jpg・png・gif形式のいずれかを選択して下さい",
            "post_image.max" => "10M以下の画像を選択してください",
        ]);

        if($request->post_image){
            //画像の処理
            $post_image = Image::read($request->file('post_image'));

            $post_image_name = time().'-'.$request->file('post_image')->getClientOriginalName();
            $where_post_image = public_path("images/post_images/");

            $width = $post_image->width();
            $height = $post_image->height();

            if($width <= $height){
                $post_image->scale(500,1000);
                $post_image->save($where_post_image.$post_image_name);
            }else{
                $post_image->scale(1000,500);
                $post_image->save($where_post_image.$post_image_name);
            }

            $post_image_path = "images/post_images/".$post_image_name;
        }else{
            $post_image_path = null;
        }



        //現在時刻、ユーザーIDを取得
        date_default_timezone_set('Asia/Tokyo');
        $now = date('Y-m-d H:i:s');
        $user_id = auth()->user()->id;

        //DBに登録
        $new_post = new Post;
        $new_post->user_id = $user_id;
        $new_post->post = $request->input('post');
        $new_post->image_path = $post_image_path;
        $new_post->created_at = $now;
        $new_post->save();

        return redirect()->route("timeline");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //DBからポストの詳細情報を取得する
        $post = DB::table('users')->join('posts', "users.id", "=", "posts.user_id")
                    ->select("users.id", "users.name", "users.icon_path", "posts.id", "posts.post", "posts.image_path", "posts.created_at")
                    ->where('posts.id', $id)
                    ->get()
                    ->first();

        //そのポストに対するスレッドも取得する
        $threads = DB::table('users')->join("threads", "users.id", "=", "threads.user_id")
                    ->select('users.id', "users.name", "users.icon_path", "threads.id", "threads.text", "threads.image_path", "threads.created_at")
                    ->where("threads.post_id", $id)
                    ->orderBy('created_at', "ASC")
                    ->get();

        // dd($threads);

        return view('post_detail', ['post' => $post, "threads" => $threads]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * 検索フォームに入力されたデータに基づいて、ポストを検索
     */
    public function search(Request $request)
    {
        $request->validate([
            "search_word" => "required|min:2|max:100",
        ],
        [
            "search_word.required" => "検索ワードを入力して下さい",
            "search_word.max" => "100文字以内で入力して下さい",
            "search_word.min" => "2文字以上で入力して下さい",
        ]);


        $posts = DB::table('users')->join('posts', "users.id", "=", "posts.user_id")
        ->select("users.name", "users.icon_path", "posts.id", "posts.post", "posts.image_path", "posts.created_at")
        //あいまい検索（投稿内容）
        ->where("posts.post", "like", "%" . $request->input('search_word'). "%")
        //あいまい検索（名前）
        ->orWhere("users.name", "like", "%" . $request->input('search_word'). "%")
        ->orderBy("created_at", "DESC")
        ->limit(10)
        ->get();

        // dd($posts);

        if(isset($posts)){
            //検索結果があったら、返す
            return view("search", ["posts" => $posts, "search_word" => $request->input('search_word')]);
        }else{
            return view("search", ["search_word" => $request->input('search_word')]);
        }
    }
}
