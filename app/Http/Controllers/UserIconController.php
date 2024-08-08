<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;

class UserIconController extends Controller
{
    /**
     * ユーザーアイコンを設定・更新します
     */
    public function update(Request $request)
    {
        //ファイルの形式をチェック
        $request->validate([
            "icon" => "required|image|mimes:jpeg,png,jpg|max:4096",
        ]);

        //画像の取得
        $image = Image::read($request->file("icon"));


        //オリジナル画像を保存
        $imageName = time().'-'.$request->file('icon')->getClientOriginalName();
        $where_image = public_path('images/originals/');
        $image->save($where_image.$imageName);


        //画像の中央を50x50で切り取ったアイコンを作成し、保存
        $where_icon = public_path('images/icons/');
        //丸く切り抜きます
        $width = $image->width();
        $height = $image->height();

        $size = min($width, $height);

        $centerX = $width /2;
        $centerY = $height/2;

        $image->crop($size, $size, $centerX - $size/2, $centerY - $size/2)
              ->resize(100,100)
              ->save($where_icon.$imageName);



        // 画像のパスをDBに保存
        $user = auth()->user();
        $user->icon_path = "images/icons/".$imageName;
        $user->save();



        return back()->with("成功", "アイコンの作成が完了しました")
                     ->with('imageName', $imageName);
    }

    /**
     * ユーザーアイコンを削除します
     */
    public function destroy(string $id)
    {
        //
    }
}
