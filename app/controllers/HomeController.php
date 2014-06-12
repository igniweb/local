<?php

use Local\Services\SocialWall\Repositories\Models\SocialItem;

class HomeController extends BaseController {

    public function index()
    {
        return View::make('home.index');
    }

    public function socialWall()
    {
        $items = SocialItem::orderBy('feeded_at', 'desc')->take(20)->get();

        return View::make('home.social-wall', compact('items'));
    }

}
