@extends('layouts.bootplus.layout')

@section('content')
<div id="masonry">
    @foreach ($items as $item)
        @include('social-wall._item')
    @endforeach
</div>
@stop
