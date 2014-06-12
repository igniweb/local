<?php namespace Local\Services\SocialWall\Fetchers;

use Thujohn\Twitter\Twitter as TwitterApi;

class TwitterFetcher extends AbstractFetcher {

    private $api;

    public function __construct()
    {
        $this->api = new TwitterApi;
    }

    protected function fetch($id, $account)
    {
        $data = $this->api->getUserTimeline([
            'screen_name'     => $id,
            'exclude_replies' => 0,
            'count'           => $this->limit,
        ]);

        return empty($data) ? false : $data;
    }

    protected function parse($data)
    {
        $items = [];

        $statuses = ! empty($data->statuses) ? $data->statuses : $data;
        if (is_array($statuses))
        {
            foreach ($statuses as $item)
            {
                $items[] = $item;
            }
        }

        return $items;
    }

    protected function parseItem($item, $accountId)
    {
        if ( ! empty($item->retweeted_status))
        {
            $item = $item->retweeted_status;
        }

        $media = $this->getMedia($item);

        return [
            'type'        => 'twitter',
            'type_id'     => $item->id_str,
            'account_id'  => $accountId,
            'url'         => 'https://twitter.com/' . $item->user->id_str . '/status/' . $item->id_str,
            'title'       => null,
            'content'     => $this->clean($item->text),
            'user_name'   => $item->user->screen_name,
            'user_icon'   => $item->user->profile_image_url,
            'media'       => $media,
            'media_thumb' => $this->getMediaThumb($item),
            'media_type'  => $this->getMediaType($media),
            'favorites'   => intval($item->retweet_count),
            'feeded_at'   => date('Y-m-d H:i:s', strtotime($item->created_at)),
        ];
    }

    private function getMedia($item)
    {
        if ( ! empty($item->entities->media[0]))
        {
            $media = $item->entities->media[0];

            return $media->media_url;
        }

        return null;
    }

    private function getMediaThumb($item)
    {
        $mediaThumb = null;

        if ( ! empty($item->entities->media[0]))
        {
            $media = $item->entities->media[0];

            $mediaThumb = $media->media_url;
            if (isset($media->sizes->small))
            {
                $mediaThumb .= ':small';
            }
            elseif (isset($media->sizes->medium))
            {
                $mediaThumb .= ':medium';
            }
        }

        return $mediaThumb;
    }
    
}
