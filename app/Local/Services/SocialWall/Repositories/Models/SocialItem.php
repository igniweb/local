<?php namespace Local\Services\SocialWall\Repositories\Models;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Lang;

class SocialItem extends Eloquent {

    use SoftDeletingTrait;

    public $table = 'social_items';

    protected $fillable = ['type', 'type_id', 'account_id', 'url', 'title', 'content', 'media', 'media_thumb', 'media_type', 'favorites', 'feeded_at'];

    protected $dates = ['deleted_at'];

    public function getContentAttribute($value)
    {
        if ($this->type == 'twitter')
        {
            $value = $this->tweetify($value);
        }

        return str_replace("\n", "<br>", $value);
    }

    public function getMediaAttribute($value)
    {
        if ( ! empty($this->media_type) and ($this->media_type == 'video'))
        {
            $search   = ['autoplay=1', 'autoplay=0', 'autoPlay=0', 'autoPlay=1'];
            $replace  = ['', '', '', ''];
            $replaced = str_replace($search, $replace, $value);
            if ($value != $replaced)
            {
                $value = trim($replaced, '&') . '&autoplay=0';
            }
        }

        return $value;
    }

    public function getFeededAtAttribute($value)
    {
        $diffInSeconds = Carbon::now()->diffInSeconds(Carbon::createFromFormat('Y-m-d H:i:s', $value));
        $diffInSeconds = abs($diffInSeconds);

        $locale   = 'social-wall.timediff.';
        $baseUnit = 'year';

        $divs = [
            'second' => Carbon::SECONDS_PER_MINUTE,
            'minute' => Carbon::MINUTES_PER_HOUR,
            'hour'   => Carbon::HOURS_PER_DAY,
            'day'    => 30,
            'month'  => Carbon::MONTHS_PER_YEAR,
        ];

        foreach ($divs as $unit => $value)
        {
            if ($diffInSeconds < $value)
            {
                $baseUnit = $unit;
                break;
            }
            $diffInSeconds = floor($diffInSeconds / $value);
        }

        if ($diffInSeconds == 0)
        {
            $diffInSeconds = 1;
        }
        $locale .= $baseUnit;

        return Lang::choice($locale, $diffInSeconds, ['delta' => $diffInSeconds]);
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
