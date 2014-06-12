<?php namespace Local\Services\SocialWall;

use Exception;
use Local\Services\SocialWall\Repositories\SocialItemRepository;

class SocialWall {

    protected $fetcher;

    protected $socialItemRepository;

    private $items = [];

    public function __construct(FetcherInterface $fetcher, SocialItemRepository $socialItemRepository)
    {
        $this->fetcher = $fetcher;

        $this->socialItemRepository = $socialItemRepository;
    }

    public function fetch($id, $account)
    {
        $this->items = $this->fetcher->run($id, $account);
    }

    public function getItems()
    {
        return $this->items;
    }

    public function save()
    {
        if ( ! empty($this->items))
        {
            return $this->socialItemRepository->store($this->items);
        }

        throw new Exception('No items to save');
    }
    
}
