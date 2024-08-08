<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Laravel\Facades\Image;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('map');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //投稿された画像をstorageとDBに保存します
        $request->validate([
            "image" => "required|image|mimes:jpeg,jpg,png|max:30000"
        ]);

        $image = Image::read($request->file('image'));
        //画像のパス、位置情報（緯度・経度）、撮影時刻をDBに保存します（storageには画像そのものを保存）
        //画像の名前と保存場所を指定
        $imageName = time().'-'.$request->file('image')->getClientOriginalName();
        $where_map_image = public_path('images/map_images/');

        $width = $image->width();
        $height = $image->height();

        //縦横の大きさに応じて適切にトリミングして、画像を保存
        if($width <= $height){
            $image->scale(500,1000);
            $image->save($where_map_image.$imageName);
        }else{
            $image->scale(1000,500);
            $image->save($where_map_image.$imageName);
        }

        // 画像から位置情報、撮影時刻を取り出します
        $exif = @exif_read_data($where_map_image.$imageName);

        $latitude = $longitude = null;
        if(isset($exif["GPSLatitude"]) && isset($exif["GPSLongitude"])){
            $latitude = $this->convertToDecimal($exif["GPSLatitude"], $exif["GPSLatitudeRef"]);
            $longitude = $this->convertToDecimal($exif["GPSLongitude"], $exif["GPSLongitudeRef"]);
        }

        $capture_at = isset($exif["DateTime"]) ? $exif["DateTime"] : null;

        //画像に位置情報・撮影時刻が含まれている場合のみ、データを保存します。
        if(isset($latitude) || isset($longitude) || isset($capture_at)){
            //DBに保存
            dd($image);
        }else{
            back()->withErrors([
                "image_error" => "撮影場所・撮影時刻が含まれた画像を投稿して下さい",
            ]);
        }



        return redirect()->route('map');
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
