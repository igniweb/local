<?php

View::composer('layouts.bootplus._navbar', function($view)
{
    $routeType = Request::segment(2);
    $routeType = ! empty($routeType) ? $routeType : 'all';

    $view->with('routeType', $routeType)->with('types', ['twitter', 'instagram', 'facebook']);
});
