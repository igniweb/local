<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container-fluid">
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="brand" href="{{ URL::route('home') }}">{{ trans('social-wall.title') }}</a>
            <div class="nav-collapse collapse">
                <p class="navbar-text pull-right">
                    {{ trans('social-wall.brand') }}
                </p>
                <ul class="nav">
                    <li class="active"><a href="{{ URL::route('social_wall') }}">{{ trans('social-wall.filters.all') }}</a></li>
                    @foreach (['twitter', 'instagram', 'facebook'] as $type)
                        <li><a href="#{{ $type }}">{{ trans('social-wall.filters.' . $type) }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>