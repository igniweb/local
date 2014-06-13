<?php

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('social-wall', ['as' => 'social_wall', 'uses' => 'SocialWallController@index']);
Route::get('social-wall/{offset}', ['as' => 'social_wall_items', 'uses' => 'SocialWallController@items'])->where('offset', '[0-9]+');
