@if ( ! empty($item->media_type))
    <div class="item-media">
        @if ($item->media_type == 'video')

            @if (strpos($item->media, 'youtube') === false)
                <video{{ ! empty($item->media_thumb) ? ' poster="' . $item->media_thumb . '"' : '' }} controls>
                    <source src="{{ $item->media }}">
                </video>
            @else
                <iframe width="560" height="315" src="{{ $item->media }}" frameborder="0" allowfullscreen></iframe>
            @endif

        @else

            @if ( ! empty($item->media_thumb))
                <a href="{{ $item->media }}" target="_blank"><img src="{{ $item->media_thumb }}" class="img-polaroid"></a>
            @endif

        @endif
    </div>
@endif