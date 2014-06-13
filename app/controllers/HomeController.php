<?php

use Local\Services\SocialWall\Repositories\SocialAccountRepository;
use Local\Services\SocialWall\Repositories\SocialItemRepository;

class HomeController extends BaseController {

    protected $accountRepository;

    protected $itemRepository;

    public function __construct(SocialAccountRepository $accountRepository, SocialItemRepository $itemRepository)
    {
        $this->accountRepository = $accountRepository;

        $this->itemRepository = $itemRepository;
    }

    public function index()
    {
        return View::make('home.index');
    }

    public function socialWall()
    {
        $accounts = $this->accountRepository->getById();

        $items = $this->itemRepository->paginate(30, rand(0, 20));

        return View::make('home.social-wall', compact('accounts', 'items'));
    }

}
