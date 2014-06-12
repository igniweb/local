<?php namespace Local\Services\SocialWall\Fetchers;

use Local\Services\SocialWall\FetcherInterface;
use Patchwork\Utf8;

abstract class AbstractFetcher implements FetcherInterface {

    protected $limit = 30;

    public function run($id, $account)
    {
        $socialItems = [];

        $data = $this->fetch($id, $account);
        if ( ! empty($data))
        {
            $items = $this->parse($data);
            if ( ! empty($items))
            {
                foreach ($items as $item)
                {
                    $socialItems[] = $this->parseItem($item, $account['id']);
                }
            }
        }

        return $socialItems;
    }

    abstract protected function fetch($id, $account);

    abstract protected function parse($data);

    abstract protected function parseItem($item, $accountId);

    protected function clean($str)
    {
        return Utf8::utf8_encode(Utf8::utf8_decode($str));
    }

    protected function getMediaType($media)
    {
        if (empty($media))
        {
            return null;
        }
        $media = strtolower($media);

        $extensions = ['png', 'jpg', 'jpeg', 'gif'];
        foreach ($extensions as $extension)
        {
            if (strpos($media, '.' . $extension) !== false)
            {
                return 'image';
            }
        }

        return 'video';
    }

}
