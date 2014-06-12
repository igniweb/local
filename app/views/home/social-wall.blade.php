@extends('layouts.social-wall')

@section('content')
<div id="masonry">
    @foreach ($items as $item)
        <div class="item">
            @if ( ! empty($item->media_thumb))
                <div><a href="{{ $item->media }}"><img src="{{ $item->media_thumb }}"></a></div>
            @endif
            <p>{{ str_replace("\n", "<br>", $item->content) }}</p>
            <p><small>{{ $item->feeded_at }}</small></p>
        </div>
    @endforeach
</div>
@stop
