<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
    <meta charset="utf-8">
    <title>{{ trans('social-wall.title') }}</title>
    <link rel="stylesheet" href="/assets/social-wall/styles/style.css">
</head>
<body id="index">
    <div id="wrapper">
        @include('layouts.social-wall._header')

        @include('layouts.social-wall._nav')

        <div id="content">
            @yield('content')
        </div>

        @include('layouts.social-wall._footer')

        @include('layouts.social-wall._top')
    </div>

    @include('layouts.social-wall._copyright')

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.js"></script>
    <script src="/vendor/imagesloaded/imagesloaded.pkgd.js"></script>
    <script src="/vendor/masonry/dist/masonry.pkgd.js"></script>
    <script src="/assets/social-wall/scripts/script.js"></script>
</body>
</html>
