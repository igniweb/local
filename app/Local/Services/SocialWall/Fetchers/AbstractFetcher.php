<?php namespace Local\Services\SocialWall\Fetchers;

use Local\Services\SocialWall\FetcherInterface;
use Patchwork\Utf8;

abstract class AbstractFetcher implements FetcherInterface {

    protected $limit = 30;

    public function run($id, $user)
    {
        $socialItems = [];

        $data = $this->fetch($id);
        if ( ! empty($data))
        {
            $items = $this->parse($data);
            if ( ! empty($items))
            {
                foreach ($items as $item)
                {
                    $socialItems[] = $this->parseItem($item, $user['id']);
                }
            }
        }

        return $socialItems;
    }

    abstract protected function fetch($id);

    abstract protected function parse($data);

    abstract protected function parseItem($item, $userId);

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
        if (strpos($media, '.png') !== false)
        {
            return 'image';
        }
        elseif (strpos($media, '.jpg') !== false)
        {
            return 'image';
        }
        elseif (strpos($media, '.gif') !== false)
        {
            return 'image';
        }

        return 'video';
    }

}
