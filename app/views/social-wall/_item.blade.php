@if ( ! empty($accounts[$item->account_id]['name']))
    <div class="item">
        <div class="well">
            @if ( ! empty($accounts[$item->account_id]['metas'][$item->type]['account_icon']))
                <h3>
                    <img class="img-circle" src="{{ $accounts[$item->account_id]['metas'][$item->type]['account_icon'] }}" style="width: 40px; height: 40px;">
                    {{ $accounts[$item->account_id]['name'] }}
                </h3>
            @else
                <h2>{{ $accounts[$item->account_id]['name'] }}</h2>
            @endif

            @include('social-wall._media')

            <p>{{ $item->content }}</p>

            <p><small>{{ Str::upper($item->type) . ' &mdash; ' . $item->feeded_at }}</small></p>

            @include('social-wall._actions')
        </div>
    </div>
@endif
