<?php namespace Local\Services\SocialWall\Repositories\Models;

use Eloquent;

class SocialAccountMeta extends Eloquent {

    public $table = 'social_account_metas';

    public $timestamps = false;

    protected $fillable = ['account_id', 'type', 'key', 'value'];

}