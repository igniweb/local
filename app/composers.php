<?php

use Local\Services\SocialWall\Repositories\Models\SocialAccount;

View::composer('layouts.bootplus._navbar', function($view)
{
    $types = ['twitter', 'instagram', 'facebook'];

    $routeType = Request::segment(2);
    $routeType = ! empty($routeType) ? $routeType : 'all';

    $accounts = SocialAccount::orderBy('name', 'asc')->get();

    $routeAccount = Request::segment(3);
    $routeAccount = ! empty($routeAccount) ? $routeAccount : 'all';

    $view->with('types', $types)->with('routeType', $routeType)->with('accounts', $accounts)->with('routeAccount', $routeAccount);
});
