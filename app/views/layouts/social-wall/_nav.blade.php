<nav id="primary">
    <div class="boxed">
        <div id="logo-head">
           <a href="{{ URL::route('home') }}"><img src="/assets/social-wall/images/logo.png" alt="{{ trans('social-wall.title') }}"></a>
        </div>
        @include('layouts.social-wall._menu')
    </div>
</nav>
