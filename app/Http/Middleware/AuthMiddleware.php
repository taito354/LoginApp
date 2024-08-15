<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

//追記
use Illuminate\Support\Facades\Auth;

class AuthMiddleware
{
    /**
     * アクセスしたユーザーのログイン状態をチェックする、ログインしてないならログインさせる
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //アクセスしたリクエストがログイン済みかチェックする
        if(Auth::check()){

            //ログインしているなら、コントローラーに繋ぐ
            return $next($request);

        }else{

            //ログインしていないなら、ログインフォームに返す
            return redirect()->route("login.form");
        }

    }
}
