<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>{{ trans('social-wall.title') }}</title>
    <link rel="stylesheet" href="/assets/laravel/styles/style.css">
</head>
<body id="index">
    <div id="wrapper">
        @include('layouts.laravel._header')

        @include('layouts.laravel._nav')

        <div id="content">
            @yield('content')
        </div>

        @include('layouts.laravel._footer')

        @include('layouts.laravel._top')
    </div>

    @include('layouts.laravel._copyright')

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
    <script src="/vendor/imagesloaded/imagesloaded.pkgd.js"></script>
    <script src="/vendor/masonry/dist/masonry.pkgd.js"></script>
    <script src="/assets/laravel/scripts/script.js"></script>
</body>
</html>
