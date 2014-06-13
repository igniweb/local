@if ( ! empty($accounts[$item->account_id]['metas'][$item->type]['account_name']))
    <div class="item{{ (rand(0, 4) == 3) ? ' w2' : '' }}">
        <div class="social-item box_shadow {{ $item->type }}" data-type_id="{{ $item->type_id }}" data-account="{{ $item->account_id }}">
            @if ( ! empty($item->media_thumb))
                <div class="aligncenter"><a href="{{ $item->media }}"><img src="{{ $item->media_thumb }}"></a></div>
            @endif
            <p class="social-item-content">{{ $item->content }}</p>
            <div class="social-item-metas">
                <p>
                    @if ( ! empty($accounts[$item->account_id]['metas'][$item->type]['account_icon']))
                        <img src="{{ $accounts[$item->account_id]['metas'][$item->type]['account_icon'] }}" width="50" height="50">
                    @endif
                    {{ $accounts[$item->account_id]['metas'][$item->type]['account_name'] }}
                </p>
                <p><small>{{ $item->feeded_at->diffForHumans() }}</small> <span class="label {{ $item->type }}">{{ Str::upper($item->type) }}</span></p>
            </div>
        </div>
    </div>
@endif