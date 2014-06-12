<?php namespace Local\Services\SocialWall\Repositories\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SocialAccount extends Eloquent {

    use SoftDeletingTrait;

    public $table = 'social_accounts';

    protected $fillable = ['name', 'slug', 'twitter', 'instagram', 'facebook'];

    protected $dates = ['deleted_at'];

    public function metas()
    {
        return $this->hasMany('Local\Services\SocialWall\Repositories\Models\SocialAccountMeta', 'account_id', 'id');
    }

}
