<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;



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
     * 会員登録ページから入力された情報をDBに保存します
     */
    public function store(Request $request)
    {
        //受け取ったデータをチェックする
        $request->validate([
            "name" => "required|max:100",
            "email" => "required|email|max:100",
            "password" => "required|max:100",
        ]);

        //すでにあるemail情報でないかチェックする
        $account = DB::table('users')->select('email')
                                     ->where('email', $request->input('email'))
                                     ->get();

        //すでに登録してあるemailアドレスが無ければ、受け取ったデータをDBに登録する
        if(count($account) < 1){
            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();

            //ログイン完了後の画面に移行する
            return redirect("/login");
        }else{
            //すでに登録されていたら、エラーで返す
            return back()->withErrors([
                        "email_error" => "このメールアドレスはすでに登録されています"
                    ])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * アカウント情報編集画面を表示する
     */
    public function edit()
    {
        //ログイン中のアカウント情報を取得する
        $user_id = Auth::user()->id;

        //DBからログイン中のアカウントの情報を取得する
        $account_data = DB::table('users')->select('id', 'name', 'email')
                                    ->where("id", $user_id)
                                    ->get()
                                    ->first();

        //編集画面に取得した情報を渡す
        return view('account_edit', compact('account_data'));
    }

    /**
     * フォームに入力された名前、メールアドレス情報を更新する
     */
    public function update(Request $request)
    {
        //受け取ったデータをチェックする
        $request->validate([
            "name" => "required|max:100",
            "email" => "required|email|max:100",
        ]);

        //ログイン中のユーザーのidを取得する
        $user_id = Auth::user()->id;

        //現在時刻をを変数に入れる
        date_default_timezone_set('Asia/Tokyo');
        $now = date('Y-m-d H:i:s');

        //DB上の名前、メールアドレスを更新する
        DB::table('users')->where('id', $user_id)->update([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "updated_at" => $now,
        ]);

        return redirect()->route('dashboard');

    }

    /**
     * フォームに更新されたパスワードを更新する
     */
    public function update_password(Request $request)
    {
        //受け取ったデータをチェックする
        $request->validate([
            "email_2" => "required|email|max:100",
            "new_password" => "required|min:8|max:100",
            "current_password" => "required|min:8|max:100",
        ]);

        //入力されたパスワードに変更がなければ、「新しいパスワードが現在と同じです」で戻す
        if($request->input('current_password') === $request->input('new_password')){

            return back()->withErrors([
                        "password_edit_error" => "新しいパスワードが現在と同じです",
            ]);

        }else{

            // 入力内容を配列形式にして、認証する
            $check_form_data = [
                "email" => $request->input("email_2"),
                "password" => $request->input("current_password"),
            ];

            if(Auth::attempt($check_form_data)){
                //認証に成功したら、パスワードをハッシュ化して、DB上のパスワードを更新する
                $hashed_password = Hash::make($request->input('new_password'));

                //現在時刻をを変数に入れる
                date_default_timezone_set('Asia/Tokyo');
                $now = date('Y-m-d H:i:s');

                DB::table('users')->where('email', $check_form_data["email"])
                                  ->update([
                                    "password" => $hashed_password,
                                    "updated_at" => $now,
                                    ]);

                return redirect()->route("dashboard");

            }else{
                // 認証失敗したら、戻す（現在のパスワードが間違っている場合など）
                return back()->withErrors([
                            "password_edit_error" => "入力内容に間違いがないか確認して下さい"
                        ])->withInput();
            }
        }
    }

    /**
     * ユーザーアカウントを削除する
     */
    public function destroy()
    {
        //alertを表示して、パスワードの入力を求める
        $user_id = Auth::user()->id;

        DB::table('users')->where('id', $user_id)
                          ->delete();

        return redirect("/");
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

        return redirect()->route('login.form');
    }
}
