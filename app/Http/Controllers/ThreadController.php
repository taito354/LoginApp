<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//追記
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ThreadRequest;
use Carbon\Carbon;
use Intervention\Image\Laravel\Facades\Image;

class ThreadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        return view('thread.thread_form', ["id" => $id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ThreadRequest $request, $id)
    {
        //ThreadRequeatでチェックした値を受け取る
        $validated = $request->validated();

        //画像の処理
        if($request->thread_image){
            $thread_image = Image::read($request->file('thread_image'));

            $thread_image_name = time().'-'.$request->file('thread_image')->getClientOriginalName();
            $where_thread_image = public_path("images/thread_images/");

            $width = $thread_image->width();
            $height = $thread_image->height();

            if($width <= $height){
                $thread_image->scale(500,1000);
                $thread_image->save($where_thread_image.$thread_image_name);
            }else{
                $thread_image->scale(1000,500);
                $thread_image->save($where_thread_image.$thread_image_name);
            }

            $thread_image_path = "images/thread_images/".$thread_image_name;
        }else{
            $thread_image_path = null;
        }

        date_default_timezone_set('Asia/Tokyo');

        $thread = [
            "post_id" => $id,
            "user_id" => auth()->user()->id,
            "text" => $validated["text"],
            "image_path" => $thread_image_path,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ];

        DB::table("threads")->insert($thread);

        return redirect()->route("post.show", ["id" => $id]);
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
