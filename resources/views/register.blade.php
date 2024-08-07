@extends('layouts.guest')


@section('title', 'ユーザー登録')


@section('content')
<div class="login_form">
    <form action="{{ route('user.store') }}" method="post" class="form">
        <h1>HOTARUER</h1>
        @csrf

        <label for="name">名前</label>
        <div class="input">
            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="名前を入力してください">
        </div>

        @error('name')
             <div class="error_message">名前を入力して下さい</div>
        @enderror

        <label for="email">メールアドレス</label>
        <div class="input">
            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="メールアドレスを入力してください">
        </div>

        @error('email')
        <div class="error_message">メールアドレスを入力して下さい</div>
        @enderror

        @error("email_error")
            <div class="error_message">{{ $message }}</div>
        @enderror

        <label for="password">パスワード</label>
        <div class="input">
            <input type="text" id="password" name="password" value="{{ old('password') }}" placeholder="パスワードを8文字以上で入力してください">
        </div>

        @error('password')
        <div class="error_message">パスワードを入力して下さい</div>
        @enderror

        <input type="submit" value="登録" class="submit_btn">
    </form>
</div>

@endsection


@push('styles')
    <link rel="stylesheet" href="{{ asset('css/register/register.css') }}">
@endpush
