<?php

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('social-wall/{type}/{offset}', ['as' => 'social_wall_items', 'uses' => 'SocialWallController@items'])->where('type', '[a-z]+')->where('offset', '[0-9]+');
Route::get('social-wall/{type?}', ['as' => 'social_wall', 'uses' => 'SocialWallController@index']);
