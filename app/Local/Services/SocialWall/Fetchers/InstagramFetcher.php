<?php namespace Local\Services\SocialWall\Fetchers;

use Local\Services\SocialWall\Apis\InstagramApi;

class InstagramFetcher extends AbstractFetcher {

    private $api;

    public function __construct()
    {
        $this->api = new InstagramApi;
    }

    protected function fetch($id, $account)
    {
        $userId = false;
        if ( ! empty($account['metas']))
        {
            $userId = $this->getUserId($account['metas']);
        }

        if ( ! empty($userId))
        {
            return $this->api->query('users/' . $userId . '/media/recent');
        }

        return false;
    }

    protected function parse($data)
    {
        return $data;
    }

    protected function parseItem($item, $accountId)
    {
        $media = $this->getMedia($item);

        return [
            'type'        => 'instagram',
            'type_id'     => $item->id,
            'account_id'  => $accountId,
            'url'         => $item->link,
            'title'       => null,
            'content'     => ! empty($item->caption->text) ? $this->clean($item->caption->text) : null,
            'media'       => $media,
            'media_thumb' => $this->getMediaThumb($item),
            'media_type'  => $this->getMediaType($media),
            'favorites'   => ! empty($item->likes->count) ? intval($item->likes->count) : 0,
            'feeded_at'   => date('Y-m-d H:i:s', $item->created_time),
        ];
    }

    private function getUserId($metas)
    {
        foreach ($metas as $key => $val)
        {
            if ($key == 'user_id')
            {
                return $val;
            }
        }

        return false;
    }

    private function getMedia($item)
    {
        if ( ! empty($item->images->standard_resolution->url))
        {
            return $item->images->standard_resolution->url;
        }
        elseif ( ! empty($item->videos->standard_resolution->url))
        {
            return $item->videos->standard_resolution->url;
        }

        return null;
    }

    private function getMediaThumb($item)
    {
        if ( ! empty($item->images->low_resolution->url))
        {
            return $item->images->low_resolution->url;
        }

        return $this->getMedia($item);
    }
    
}
