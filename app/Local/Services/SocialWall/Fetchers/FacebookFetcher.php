<?php namespace Local\Services\SocialWall\Fetchers;

use Local\Services\SocialWall\Apis\FacebookApi;

class FacebookFetcher extends AbstractFetcher {

    private $api;

    const MAX_THUMB_WIDTH = 250;

    public function __construct()
    {
        $this->api = new FacebookApi(['appId' => $_ENV['FACEBOOK_ID'], 'secret' => $_ENV['FACEBOOK_SECRET']]);
    }

    protected function fetch($id, $account)
    {
        $id = ! empty($account['metas']['page_id']) ? $account['metas']['page_id'] : null;
        if (empty($id))
        {
            $id = ! empty($account['metas']['graph_id']) ? $account['metas']['graph_id'] : null;
        }

        if ( ! empty($id))
        {
            return $this->api->api('/' . $id . '/posts', 'GET');
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
        $url = false;
        if ( ! empty($item['link']))
        {
            $url = $item['link'];
        }
        elseif ( ! empty($item['object_id']))
        {
            $url = 'https://www.facebook.com/' . $item['object_id'];
        }

        if ($url !== false)
        {
            return [
                'type'        => 'facebook',
                'type_id'     => $item['id'],
                'account_id'  => $accountId,
                'url'         => $url,
                'title'       => null,
                'content'     => $this->getContent($item),
                'favorites'   => ! empty($item['likes']) ? count($item['likes']) : 0,
                'feeded_at'   => date('Y-m-d H:i:s', strtotime($item['created_time'])),
            ] + $this->getMedia($item);
        }

        return false;
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
        $media = [
            'media'       => null,
            'media_thumb' => null,
            'media_type'  => null,
        ];

        if (isset($item['type']))
        {
            switch ($item['type'])
            {
                case 'photo':
                    if ( ! empty($item['object_id']))
                    {
                        $photo = $this->api->api('/' . $item['object_id'], 'GET');
                        if ( ! empty($photo['source']))
                        {
                            $media['media']       = $photo['source'];
                            $media['media_type']  = 'image';
                            $media['media_thumb'] = $this->getMediaThumb($photo);
                        }
                    }
                    break;
                case 'video':
                    if ( ! empty($item['source']))
                    {
                        $media['media']      = $item['source'];
                        $media['media_type'] = 'video';
                    }
                    break;
            }
        }

        return $media;
    }

    private function getMediaThumb($photo)
    {
        if ( ! empty($photo['images']))
        {
            $diffs = [];
            foreach ($photo['images'] as $image)
            {
                $diff = $image['width'] - static::MAX_THUMB_WIDTH;
                if ($diff >= 0)
                {
                    $diffs[$diff] = $image['source'];
                }
            }
            ksort($diffs);

            return (count($diffs) > 0) ? current($diffs) : $photo['images'][0]['source'];
        }

        return null;
    }
    
}
