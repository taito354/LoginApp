@extends("layouts.app")

@section("title", "掲示板")

@section("content")

    <div class="container">
        <div class="content">

            {{-- ポストを繰り返し表示 --}}
            @foreach($posts as $post)
                <div class="post">

                    <div class="head">
                        <div class="posted_at">
                            {{ $post->created_at }}
                        </div>
                        <div class="icon">
                            <a href="#"><ion-icon name="ellipsis-horizontal-outline"></ion-icon></a>
                        </div>
                    </div>

                    <div class="body">
                        <div class="upper">
                            <div class="user">
                                <img src="{{ asset($post->icon_path) }}" alt="">
                                <div class="user_name">{{ $post->name }}</div>
                            </div>
                        </div>
                        <div class="lower">
                            <div class="text">
                                {{ $post->post }}
                            </div>
                        </div>
                    </div>

                </div>
            @endforeach



        </div>

        {{-- 投稿フォーム表示ボタン（画面右下） --}}
        <div class="post_write" id="post_form_btn">
            <ion-icon name="brush-outline"></ion-icon>
        </div>


    </div>

    <div class="modal_background"></div>

    {{-- 投稿フォーム(モーダル) --}}
    <div class="post_form">
        <div class="container">
            <div class="head">
                <a href="#" class="back_btn"><ion-icon name="close-outline"></ion-icon></a>
            </div>
            <form action="{{ route('post.store') }}" method="post" enctype="multipart/form-data">
            @csrf
                <div class="post">
                    <label for="post_textarea" class="post_label">新規ポスト</label>

                    @error("post")
                        {{ $message }}
                    @enderror
                    @error("post_image")
                        {{ $message }}
                    @enderror

                    <textarea name="post" id="post_textarea" class="post_textarea"></textarea>
                    <input type="file" name="post_image">
                    <input type="submit" class="submit_btn" value="投稿">
                </div>
            </form>
        </div>
    </div>

@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset('css/time_line/time_line.css') }}">
@endpush

@push("scripts")
    {{-- ioniconの読み込む用のスクリプト --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    {{-- 投稿フォームを開くモーダルの設定用のスクリプト --}}
    <script src="{{ asset('js/post_form.js') }}"></script>
@endpush
