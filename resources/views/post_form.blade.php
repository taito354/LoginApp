@extends("layouts.app")

@section("title", "新規ポスト")

@section("content")

    {{-- 投稿フォーム(モーダル) --}}
    <div class="post_form">
        <div class="container">
            <div class="head">
                <a href="{{ route('timeline') }}" class="back_btn"><ion-icon name="close-outline"></ion-icon></a>
            </div>
            <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="post">
                    <label for="post_textarea" class="post_label">新規ポスト</label>
                    <textarea name="post" id="post_textarea" class="post_textarea"></textarea>

                    @error("post")
                        <div class="error_message">{{ $message }}</div>
                    @enderror

                    <input type="file" name="post_image">

                    @error("post_image")
                        <div class="error_message">{{ $message }}</div>
                    @enderror

                    <input type="submit" class="submit_btn" value="投稿">
                </div>
            </form>
        </div>
    </div>

@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset('css/post_form/post_form.css') }}">
@endpush

@push("scripts")
    {{-- ioniconの読み込む用のスクリプト --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@endpush
