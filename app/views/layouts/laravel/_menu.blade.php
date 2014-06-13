<ul>
    <li class="current-item"><a href="{{ URL::route('social_wall') }}">{{ trans('social-wall.filters.all') }}</a></li>
    @foreach (['twitter', 'instagram', 'facebook'] as $type)
        <li><a href="#">{{ trans('social-wall.filters.' . $type) }}</a></li>
    @endforeach
</ul>
