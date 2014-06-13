<?php

use Local\Services\SocialWall\Repositories\SocialAccountRepository;
use Local\Services\SocialWall\Repositories\SocialItemRepository;

class SocialWallController extends BaseController {

    protected $accountRepository;

    protected $itemRepository;

    const TAKE_PER_LOAD = 20;

    public function __construct(SocialAccountRepository $accountRepository, SocialItemRepository $itemRepository)
    {
        $this->accountRepository = $accountRepository;

        $this->itemRepository = $itemRepository;
    }

    public function index()
    {
        $accounts = $this->accountRepository->getById();

        $items = $this->itemRepository->paginate(static::TAKE_PER_LOAD, 0);

        return View::make('social-wall.index', compact('accounts', 'items'));
    }

    public function items($offset)
    {
        $accounts = $this->accountRepository->getById();
        
        $items = $this->itemRepository->paginate(static::TAKE_PER_LOAD, $offset);

        return View::make('social-wall.items', compact('accounts', 'items'));
    }

}
