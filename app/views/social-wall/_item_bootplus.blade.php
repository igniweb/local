@if ( ! empty($accounts[$item->account_id]['metas'][$item->type]['account_name']))
    <div class="item">
        <div class="well span{{ rand(10, 12) }}">
            @if ( ! empty($accounts[$item->account_id]['metas'][$item->type]['account_icon']))
                <div style="text-align: center;">
                    <img class="img-circle" src="{{ $accounts[$item->account_id]['metas'][$item->type]['account_icon'] }}" style="width: 70px; height: 70px;">
                </div>
            @endif
            <h2>{{ $accounts[$item->account_id]['metas'][$item->type]['account_name'] }}</h2>
            <p>{{ $item->content }}</p>
            <p><small>{{ $item->feeded_at->diffForHumans() . ' &mdash; ' . Str::upper($item->type) }}</small></p>
            <p><a class="btn btn-primary" href="{{ $item->url }}" target="_blank">{{ trans('social-wall.details') }}</a></p>
        </div>
    </div>
@endif