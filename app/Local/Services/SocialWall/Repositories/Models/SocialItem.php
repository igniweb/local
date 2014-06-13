<?php namespace Local\Services\SocialWall\Repositories\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;
use Thujohn\Twitter\Twitter as TwitterApi;

class SocialItem extends Eloquent {

    use SoftDeletingTrait;

    public $table = 'social_items';

    protected $fillable = ['type', 'type_id', 'account_id', 'url', 'title', 'content', 'media', 'media_thumb', 'media_type', 'favorites', 'feeded_at'];

    protected $dates = ['feeded_at', 'deleted_at'];

    public function getContentAttribute($value)
    {
        if ($this->type == 'twitter')
        {
            $twitterApi = new TwitterApi;

            $value = $twitterApi->linkify($value);
        }

        return str_replace("\n", "<br>", $value);
    }

}
