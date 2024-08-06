@extends('layouts.guest')


@section('title', 'ログイン')


@section('content')
<div class="login_form">
    <form action="{{ route('dashboard.login') }}" method="post" class="form">
        <h1>HOTARUER</h1>
        @csrf

        @error("email_error")
            <div class="login_error_message">{{ $message }}</div>
        @enderror

        <label for="email">メールアドレス</label>
        <div class="input">
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力してください">
        </div>

        @error('email')
        <div class="error_message">メールアドレスを入力して下さい</div>
        @enderror

        <label for="password">パスワード</label>
        <div class="input">
            <input type="text" id="password" name="password" placeholder="パスワードを入力してください">
        </div>

        @error('password')
        <div class="error_message">パスワードを入力して下さい</div>
        @enderror

        <input type="submit" value="ログイン" class="submit_btn">
    </form>
</div>

@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/login/login.css') }}">
@endpush
