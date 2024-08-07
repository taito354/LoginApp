@extends("layouts.app")

@section("title", "アカウント編集")

@section("content")

    <div class="edit_form">

        {{-- 名前・メールアドレス変更フォーム --}}
        <form action="{{ route('user.update') }}" method="post" class="form">
            <h1>名前・メールアドレス変更</h1>
            @csrf

            <label for="name">名前</label>
            <div class="input">
                <input type="text" id="name" name="name" value="{{ $account_data->name }}" placeholder="名前を入力してください">
            </div>

            @error('name')
                 <div class="error_message">名前を入力して下さい</div>
            @enderror

            <label for="email">メールアドレス</label>
            <div class="input">
                <input type="email" id="email" name="email" value="{{ $account_data->email }}" placeholder="メールアドレスを入力してください">
            </div>

            @error('email')
            <div class="error_message">メールアドレスを入力して下さい</div>
            @enderror

            <input type="submit" value="更新" class="submit_btn">
        </form>


        {{-- パスワード変更フォーム --}}
        <form action="{{ route('user.update.password') }}" method="post" class="form">
            <h1>パスワード変更</h1>
            @csrf

            {{-- 更新エラーメッセージ --}}
            @error('password_edit_error')
            <div class="error_message">{{ $message }}</div>
            @enderror

            <label for="email">メールアドレス</label>
            <div class="input">
                <input type="email" id="email" name="email_2" value="{{ $account_data->email }}" placeholder="メールアドレスを入力してください">
            </div>

            @error('email_2')
            <div class="error_message">メールアドレスを入力して下さい</div>
            @enderror

            <label for="password">新しいパスワード</label>
            <div class="input">
                <input type="text" id="password" name="new_password" value="" placeholder="新しいパスワードを8文字以上で入力してください">
            </div>

            @error('new_password')
            <div class="error_message">新しいパスワードを入力して下さい</div>
            @enderror

            <label for="password">現在のパスワード</label>
            <div class="input">
                <input type="text" id="password" name="current_password" value="" placeholder="現在のパスワードを入力してください">
            </div>

            @error('current_password')
            <div class="error_message">現在のパスワードを入力して下さい</div>
            @enderror

            <input type="submit" value="更新" class="submit_btn">
        </form>



    </div>

    <div class="delete_form">
        <div class="form">
            {{-- アカウント削除フォーム --}}
            <h1>アカウントを削除する</h1>
            <button id="delete_form_open">削除ボタンを表示</button>
            <form action="{{ route('user.delete') }}" method="post">
                @csrf

                {{-- 更新エラーメッセージ --}}
                @error('delete_error')
                <div class="error_message">{{ $message }}</div>
                @enderror


                <input id="delete_btn" type="submit" value="削除" class="submit_btn">
            </form>
        </div>
    </div>


@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset("css/account_edit/account_edit.css") }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/modal.js') }}"></script>
@endpush
