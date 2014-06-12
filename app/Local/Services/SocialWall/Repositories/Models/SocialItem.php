<?php namespace Local\Services\SocialWall\Repositories\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SocialItem extends Eloquent {

    use SoftDeletingTrait;

    public $table = 'social_items';

    protected $fillable = ['type', 'type_id', 'account_id', 'url', 'title', 'content', 'user_name', 'user_icon', 'media', 'media_thumb', 'media_type', 'favorites', 'feeded_at'];

    protected $dates = ['feeded_at', 'deleted_at'];

}
