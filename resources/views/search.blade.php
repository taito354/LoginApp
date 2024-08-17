@extends("layouts.app")

@section("title", "検索結果")

@section("content")

    <div class="container">

        {{-- タイムラインに戻るボタン --}}
        <a href="{{ route('timeline') }}" class="back_btn"><ion-icon name="backspace-outline"></ion-icon></a>

        <div class="content">


            <div class="search_word">"{{ $search_word }}"の検索結果</div>

            {{-- 検索結果のポストを繰り返し表示 --}}
            @foreach($posts as $post)
                <div class="post">

                    <div class="head">
                        <div class="posted_at">
                            {{ $post->created_at }}
                        </div>
                        <div class="icon">
                            <a href="{{ route('post.show', ["id" => $post->id]) }}"><ion-icon name="ellipsis-horizontal-outline"></ion-icon></a>
                        </div>
                    </div>

                    <div class="body">
                        <div class="upper">
                            <div class="user">
                                <img src="{{ asset($post->icon_path) }}" alt="">
                                <div class="user_name">{{ $post->name }}</div>
                            </div>
                            @if($post->image_path)
                                <a href="{{ route('post.show', ["id" => $post->id]) }}"><ion-icon class="image_icon" name="image-outline"></ion-icon></a>
                            @endif
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

        {{-- 検索フォーム表示ボタン（画面左下） --}}
            <a class="search" id="search_btn" href="#">
                <ion-icon name="search-outline"></ion-icon>
            </a>

            <form action="{{ route("post.search") }}" method="post" class="search_form" id="search_form" style="display: none;">
                @csrf
                <input type="text" class="search_text" name="search_word">
                <input type="submit" class="search_submit" value="検索">
                @error("search_word")
                    <div class="error_message">{{ $message }}</div>
                @enderror
            </form>


    </div>

@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset('css/search/search.css') }}">
@endpush

@push("scripts")
    {{-- ioniconの読み込む用のスクリプト --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    {{-- スクロール位置を保存するスクリプト --}}
    <script src="{{ asset('js/scroll.js') }}"></script>
    {{-- 検索フォームに関連するスクリプト --}}
    <script src="{{ asset("js/modal_btn.js") }}"></script>
@endpush
