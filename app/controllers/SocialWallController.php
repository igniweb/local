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

    public function index($type = 'all', $account = 'all', $page = 0)
    {
        $type      = $this->validType($type);
        $accountId = $this->getAccountId($account);

        $accounts = $this->accountRepository->getById();
        $items    = $this->itemRepository->paginate($type, $accountId, intval($page), static::TAKE_PER_LOAD);

        return View::make('social-wall.index', compact('type', 'accountId', 'accounts', 'items'));
    }

    public function items($type, $accountId, $page)
    {
        $accounts = $this->accountRepository->getById();
        $items    = $this->itemRepository->paginate($this->validType($type), $accountId, intval($page), static::TAKE_PER_LOAD);

        return View::make('social-wall.items', compact('accounts', 'items'));
    }

    private function validType($type)
    {
        if ( ! in_array($type, ['all', 'twitter', 'instagram', 'facebook']))
        {
            $type = 'all';
        }

        return $type;
    }

    private function getAccountId($account)
    {
        $accountModel = $this->accountRepository->findBySlug($account);

        if (empty($accountModel))
        {
            return 'all';
        }

        return $accountModel->id;
    }

}
