<?php

class HomeController extends BaseController {

    public function index()
    {
        return View::make('home.index');
    }

    public function socialWall()
    {
        return View::make('home.social-wall');
    }

}
