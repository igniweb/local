<nav id="primary">
    <div class="boxed">
        <div id="logo-head">
           <a href="{{ URL::route('home') }}"><img src="/assets/laravel/images/logo.png" alt="{{ trans('social-wall.title') }}"></a>
        </div>
        @include('layouts.laravel._menu')
    </div>
</nav>
