@extends("layouts.app")

@section("title", "Map")

@section("content")

    <div class="container">

        <div class="content">

            {{-- 投稿を反映させるマップ --}}
            <div class="map" id="map"></div>

            {{-- 投稿するフォーム --}}
            <div class="form">
                <form action="{{ route('map.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <h1>ホタルイカ画像を投稿しましょう</h1>

                    {{-- ここにエラー文を表示 --}}
                    @error("image_error")
                        <div class="error_message">{{ $message }}</div>
                    @enderror

                    <input type="file" class="image_select" name="image">

                    <input type="submit" class="submit_btn" value="確認">
                </form>
            </div>

        </div>

    </div>

    {{-- google map apiの読み込み --}}
    <script async defer src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key={{ env("GOOGLE_MAPS_API_KEY") }}&callback=initMap&libraries=marker"></script>

@endsection

@push("styles")
    <link rel="stylesheet" href="{{ asset('css/map/map.css') }}">
@endpush

@push("scripts")
    <script src="{{ asset('js/map.js') }}"></script>
@endpush
