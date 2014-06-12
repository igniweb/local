<footer id="foot" class="textcenter">
    <div class="boxed">
        <nav id="secondary">
            {{--
            <div id="logo-foot">
                <a href="{{ URL::route('home') }}">{{ trans('social-wall.title') }}</a>
            </div>
            --}}
            @include('layouts.social-wall._menu')
        </nav>
    </div>
</footer>
