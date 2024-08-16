@extends("layouts.app")

@section("title", "ポスト詳細")

@section("content")

    <div class="container">

        <a href="{{ route('timeline') }}" class="back_btn"><ion-icon name="backspace-outline"></ion-icon></a>

        <div class="content">

            <div class="post">

                <div class="head">
                    <div class="posted_at">
                        {{ $post->created_at }}
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
                        @if(isset($post->image_path))
                            <img src="{{ asset($post->image_path) }}" class="post_image" alt="">
                        @endif
                    </div>
                </div>

            </div>

            {{-- 繰り返し表示 --}}
            @foreach($threads as $thread)
                <div class="thread">

                    <div class="head">
                        <div class="posted_at">
                            {{ $thread->created_at }}
                        </div>
                    </div>

                    <div class="body">
                        <div class="upper">
                            <div class="user">
                                <img src="{{ asset($thread->icon_path) }}" alt="">
                                <div class="user_name">{{ $thread->name }}</div>
                            </div>
                        </div>
                        <div class="lower">
                            <div class="text">
                                {{ $thread->text }}
                            </div>
                            @if(isset($thread->image_path))
                                <img src="{{ asset($thread->image_path) }}" class="post_image" alt="">
                            @endif
                        </div>
                    </div>

                </div>
            @endforeach

        </div>

        <a href="{{ route("thread.create", ["id" => $post->id]) }}" class="new_thread_btn">
            <ion-icon name="create-outline"></ion-icon>
            <div class="new_comment">コメントする</div>
        </a>

    </div>

@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset('css/post_detail/post_detail.css') }}">
@endpush

@push("scripts")
    {{-- ioniconの読み込む用のスクリプト --}}
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
@endpush
