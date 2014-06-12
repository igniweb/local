<?php namespace Local\Services\SocialWall\Fetchers;

use Local\Services\SocialWall\Apis\FacebookApi;

class FacebookFetcher extends AbstractFetcher {

    private $api;

    public function __construct()
    {
        $this->api = new FacebookApi(['appId' => $_ENV['FACEBOOK_ID'], 'secret' => $_ENV['FACEBOOK_SECRET']]);
    }

    protected function fetch($id, $account)
    {
        if ( ! empty($account['page_id']))
        {
            return $this->api->api('/' . $account['page_id'] . '/feed', 'GET');
        }

        return false;
    }

    protected function parse($data)
    {
        $items = [];

        if ( ! empty($data['data']))
        {
            foreach ($data['data'] as $item)
            {
                $items[] = $item;
            }
        }

        return $items;
    }

    protected function parseItem($item, $accountId)
    {
        $media = $this->getMedia($item);
//dd($item);
        return [
            'type'        => 'facebook',
            'type_id'     => $item['id'],
            'account_id'  => $accountId,
            'url'         => null,
            'title'       => null,
            'content'     => $this->getContent($item),
            'user_name'   => $item['from']['name'],
            'user_icon'   => ! empty($item->user->profile_picture) ? $item->user->profile_picture : null,
            'media'       => $media,
            'media_thumb' => $this->getMediaThumb($item),
            'media_type'  => $this->getMediaType($media),
            'favorites'   => ! empty($item['likes']) ? count($item['likes']) : 0,
            'feeded_at'   => date('Y-m-d H:i:s', strtotime($item['created_time'])),
        ];
    }

    private function getContent($item)
    {
        $content = null;

        if ( ! empty($item['message']))
        {
            $content = $item['message'];
        }
        elseif ( ! empty($item['story']))
        {
            $content = $item['story'];
        }

        return $content;
    }

    private function getMedia($item)
    {
        return null;
    }

    private function getMediaThumb($item)
    {
        return null;
    }
    
}
