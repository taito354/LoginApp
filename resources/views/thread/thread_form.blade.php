@extends("layouts.app")

@section("title", "新規コメント")

@section("content")

    {{-- 投稿フォーム --}}
    <div class="thread_form">
        <div class="container">
            <div class="head">
                <a href="{{ route('post.show', ["id" => $id]) }}" class="back_btn"><ion-icon name="close-outline"></ion-icon></a>
            </div>
            <form action="{{ route('thread.store', ["id" => $id]) }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="post">
                    <label for="text" class="post_label">新規コメント</label>
                    <textarea name="text" id="text" class="post_textarea"></textarea>

                    @error("text")
                        <div class="error_message">{{ $message }}</div>
                    @enderror

                    <input type="file" name="thread_image">

                    @error("thread_image")
                        <div class="error_message">{{ $message }}</div>
                    @enderror

                    <input type="submit" class="submit_btn" value="コメント">
                </div>
            </form>
        </div>
    </div>

@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset('css/thread_form/thread_form.css') }}">
@endpush

@push("scripts")
    {{-- ioniconの読み込む用のスクリプト --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@endpush
