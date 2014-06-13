@if ( ! empty($accounts[$item->account_id]['metas'][$item->type]['account_name']))
    <div class="item">
        <div class="well">
            @if ( ! empty($accounts[$item->account_id]['metas'][$item->type]['account_icon']))
                <h3>
                    <img class="img-circle" src="{{ $accounts[$item->account_id]['metas'][$item->type]['account_icon'] }}" style="width: 40px; height: 40px;">
                    {{ $accounts[$item->account_id]['metas'][$item->type]['account_name'] }}
                </h3>
            @else
                <h2>{{ $accounts[$item->account_id]['metas'][$item->type]['account_name'] }}</h2>
            @endif

            @if ( ! empty($item->media_thumb))
                <div style="text-align: center;">
                    <a href="{{ $item->media }}" target="_blank"><img src="{{ $item->media_thumb }}" class="img-polaroid"></a>
                </div>
            @endif

            <p>{{ $item->content }}</p>

            <p><small>{{ Str::upper($item->type) . ' &mdash; ' . $item->feeded_at->diffForHumans() }}</small></p>

            <p style="text-align: right;">
                <a class="btn btn-primary" href="{{ $item->url }}" target="_blank">{{ trans('social-wall.details') }}</a>
            </p>
        </div>
    </div>
@endif
