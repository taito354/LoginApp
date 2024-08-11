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
        return view('time_line');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
            "post.required" => "ポストは入力が必須です",
            "post.max:500" => "ポストは500字以内で入力して下さい",
            "post_image.image" => "画像はjpeg・jpg・png・gif形式のいずれかを選択して下さい",
        ]);

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
        //
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
}
