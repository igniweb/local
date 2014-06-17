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

    public function index($type = 'all')
    {
        $type = $this->validType($type);

        $accounts = $this->accountRepository->getById();

        $items = $this->itemRepository->paginate($type, static::TAKE_PER_LOAD, 0);

        return View::make('social-wall.index', compact('type', 'accounts', 'items'));
    }

    public function items($type, $offset)
    {
        $accounts = $this->accountRepository->getById();

        $items = $this->itemRepository->paginate($this->validType($type), static::TAKE_PER_LOAD, intval($offset));

        return View::make('social-wall.index', compact('accounts', 'items'));
    }

    private function validType($type)
    {
        if (! in_array($type, ['all', 'twitter', 'instagram', 'facebook']))
        {
            $type = 'all';
        }

        return $type;
    }

}
