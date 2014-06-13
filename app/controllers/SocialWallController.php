<?php

use Local\Services\SocialWall\Repositories\SocialAccountRepository;
use Local\Services\SocialWall\Repositories\SocialItemRepository;

class SocialWallController extends BaseController {

    protected $accountRepository;

    protected $itemRepository;

    public function __construct(SocialAccountRepository $accountRepository, SocialItemRepository $itemRepository)
    {
        $this->accountRepository = $accountRepository;

        $this->itemRepository = $itemRepository;
    }

    public function index()
    {
        $accounts = $this->accountRepository->getById();

        $items = $this->itemRepository->paginate(30, rand(0, 10));

        return View::make('social-wall.index', compact('accounts', 'items'));
    }

}