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
                    <img src="/assets/bootplus/images/loader16.gif" class="loader" alt="{{ trans('social-wall.loading') }}" style="margin-right: 1em;">
                    {{ trans('social-wall.brand') }}
                </p>
                <ul class="nav">
                    <li{{ ($routeType == 'all') ? ' class="active"': '' }}><a href="{{ URL::route('social_wall') }}">{{ trans('social-wall.filters.all') }}</a></li>
                    @foreach ($types as $type)
                        <li{{ ($routeType == $type) ? ' class="active"': '' }}><a href="{{ URL::route('social_wall', [$type]) }}">{{ trans('social-wall.filters.' . $type) }}</a></li>
                    @endforeach
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{ trans('social-wall.accounts.title') }} &#9662;</a>
                        <ul class="dropdown-menu" role="menu" aria-labelledby="dLabel">
                            <li><a href="{{ URL::route('social_wall', [$routeType]) }}">{{ (($routeAccount == 'all') ? '<strong>' : '') . trans('social-wall.accounts.all') . (($routeAccount == 'all') ? '</strong>' : '') }}</a></li>
                            <li class="divider"></li>
                            @foreach ($accounts as $account)
                                <li><a href="{{ URL::route('social_wall', [$routeType, $account->slug]) }}">{{ (($routeAccount == $account->slug) ? '<strong>' : '') . $account->name . (($routeAccount == $account->slug) ? '</strong>' : '') }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
