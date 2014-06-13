<!DOCTYPE html>
<html lang="{{ Config::get('app.locale') }}">
<head>
    <meta charset="ut8">
    <title>{{ trans('social-wall.title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,300,700">
    <link rel="stylesheet" href="/vendor/bootplus/docs/assets/css/bootplus.css" media="screen">
    <style type="text/css">
        body {
            padding-top: 60px;
            padding-bottom: 40px;
        }
        @media (max-width: 980px) {
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }
    </style>
    <link rel="stylesheet" href="/vendor/bootplus/docs/assets/css/bootplus-responsive.css" media="screen">
</head>
<body>
    @include('layouts.bootplus._navbar')

    <div class="container-fluid">
        <div class="row-fluid">
            @yield('content')

            <hr>

            <footer>
                <p>{{ trans('social-wall.copyright') }} &copy; {{ trans('social-wall.copyright-name') }}</p>
            </footer>
        </div>
    </div>

    <script src="//code.jquery.com/jquery.js"></script>
    <script src="/vendor/bootplus/docs/assets/js/bootstrap.js"></script>
    <script src="/vendor/imagesloaded/imagesloaded.pkgd.js"></script>
    <script src="/vendor/masonry/dist/masonry.pkgd.js"></script>
    <script src="/assets/bootplus/scripts/script.js"></script>
</body>
</html>