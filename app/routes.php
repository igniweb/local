<?php

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::get('social-wall', ['as' => 'social_wall', 'uses' => 'HomeController@socialWall']);
