@extends('layouts.bootplus.layout')

@section('content')
<div id="masonry" data-offset="0">
    @foreach ($items as $item)
        @include('social-wall._item')
    @endforeach
</div>

<div style="text-align: center;">
    <img src="/assets/bootplus/images/loader32.gif" class="loader" alt="{{ trans('social-wall.loading') }}">
</div>
<script>
    var socialWallType = '{{ $type }}';
</script>
@stop
