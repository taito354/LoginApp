<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title")</title>
    <link rel="stylesheet" href="{{ asset('css/doctor_reset.css')}}">
    <link rel="stylesheet" href="{{ asset('css/layouts/navi/navi.css') }}">
    @stack('styles')
</head>
<body>

    @include("layouts.navi")

    <main>
        @yield("content")
    </main>

    @stack('scripts')
</body>
</html>
