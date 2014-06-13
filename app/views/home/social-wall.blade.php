@extends('layouts.social-wall')

@section('content')
<div id="masonry">
    @foreach ($items as $item)
        <div class="item{{ (rand(0, 4) == 3) ? ' w2' : '' }}">
            <div class="social-item box_shadow">
                @if ( ! empty($item->media_thumb))
                    <div class="aligncenter"><a href="{{ $item->media }}"><img src="{{ $item->media_thumb }}"></a></div>
                @endif
                <p class="social-item-content">{{ $item->content }}</p>
                <div class="social-item-metas">
                    <p>
                        @if ( ! empty($accounts[$item->account_id]['metas'][$item->type]['account_icon']))
                            <img src="{{ $accounts[$item->account_id]['metas'][$item->type]['account_icon'] }}" width="50" height="50">
                        @endif
                        @if ( ! empty($accounts[$item->account_id]['metas'][$item->type]['account_name']))
                            {{ $accounts[$item->account_id]['metas'][$item->type]['account_name'] }}
                        @endif
                    </p>
                    <p><small>{{ $item->feeded_at }}</small> <span class="label {{ $item->type }}">{{ Str::upper($item->type) }}</span></p>
                </div>
            </div>
        </div>
    @endforeach
</div>
<div id="masonry_loader" class="aligncenter" style="margin-bottom: 50em;"><img src="/assets/social-wall/images/loader.gif" alt="{{ trans('social-wall.loading') }}"></div>
@stop
