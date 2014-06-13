<?php namespace Local\Services\SocialWall\Repositories\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SocialItem extends Eloquent {

    use SoftDeletingTrait;

    public $table = 'social_items';

    protected $fillable = ['type', 'type_id', 'account_id', 'url', 'title', 'content', 'media', 'media_thumb', 'media_type', 'favorites', 'feeded_at'];

    protected $dates = ['feeded_at', 'deleted_at'];

    public function getContentAttribute($value)
    {
        if ($this->type == 'twitter')
        {
            $value = $this->tweetify($value);
        }

        return str_replace("\n", "<br>", $value);
    }

    private function tweetify($tweet)
    {
        $tweet = ' ' . $tweet;

        $patterns             = [];
        $patterns['url']      = '(?xi)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))';
        $patterns['mailto']   = '(([a-z0-9_]|\\-|\\.)+@([^[:space:]]*)([[:alnum:]-]))';
        $patterns['user']     = ' +@([a-z0-9_]*)?';
        $patterns['hashtag']  = ' +#([a-z0-9_\p{Cyrillic}\d]*)?';
        $patterns['long_url'] = '>(([[:alnum:]]+:\/\/)|www\.)?([^[:space:]]{12,22})([^[:space:]]*)([^[:space:]]{12,22})([[:alnum:]#?\/&=])<';

        // URL
        $pattern = '(?xi)\b((?:https?://|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:\'".,<>?«»“”‘’]))';
        $tweet   = preg_replace_callback('#' . $patterns['url'] . '#i', function($matches)
        {
            $input = $matches[0];
            $url   = preg_match('!^https?://!i', $input) ? $input : "http://$input";

            return '<a href="' . $url . '" target="_blank" rel="nofollow">' . $input . "</a>";
        }, $tweet);

        // Mailto
        $tweet = preg_replace('/'.$patterns['mailto'].'/i', "<a href=\"mailto:\\1\">\\1</a>", $tweet);
        // User
        $tweet = preg_replace('/'.$patterns['user'].'/i', " <a href=\"https://twitter.com/\\1\" target=\"_blank\">@\\1</a>", $tweet);
        // Hashtag
        $tweet = preg_replace('/'.$patterns['hashtag'].'/ui', " <a href=\"https://twitter.com/search?q=%23\\1\" target=\"_blank\">#\\1</a>", $tweet);
        // Long URL
        $tweet = preg_replace('/'.$patterns['long_url'].'/', ">\\3...\\5\\6<", $tweet);

        return trim($tweet);
    }

}
