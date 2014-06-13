@extends('layouts.bootplus.layout')

@section('content')
<div id="masonry">
    @foreach ($items as $item)
        @include('social-wall._item_bootplus')
    @endforeach
</div>
<div id="masonry_loader" class="aligncenter" style="margin-bottom: 50em;"><img src="/assets/laravel/images/loader.gif" alt="{{ trans('social-wall.loading') }}"></div>
@stop
