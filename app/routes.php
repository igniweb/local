<?php

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('social-wall/{type?}/{account?}/{offset?}', ['as' => 'social_wall', 'uses' => 'SocialWallController@index']);
Route::get('social-wall/items/{type}/{accountId}/{offset}', ['as' => 'social_wall_items', 'uses' => 'SocialWallController@items']);
