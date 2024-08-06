<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //受け取ったデータをチェックする
        $request->validate([
            "name" => "required|max:100",
            "email" => "required|email|max:100",
            "password" => "required|max:100",
        ]);

        //受け取ったデータをDBに登録する
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        //ログイン完了後の画面に移行する
        return redirect()->route("dashboard");
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


    /**
     * ユーザーのログイン認証をします
     */
    public function login(Request $request)
    {
        //入力されたデータをチェックします
        $user = $request->validate([
            "email" => "required|max:100",
            "password" => "required|max:100",
        ]);

        if(Auth::attempt($user)){
            return redirect()->route("dashboard");
        }

        return back()->withErrors([
            'email_error' => "ログインに失敗しました",
        ])->onlyInput('email');
    }

    /**
     * ユーザーのログイン認証をします
     */
    public function logout(Request $request)
    {
        //現在のログイン情報を削除します
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
