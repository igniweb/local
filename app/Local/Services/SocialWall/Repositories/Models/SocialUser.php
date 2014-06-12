<?php namespace Local\Services\SocialWall\Repositories\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SocialUser extends Eloquent {

    use SoftDeletingTrait;

    public $table = 'social_users';

    protected $fillable = ['name', 'slug', 'twitter', 'instagram', 'facebook', 'facebook_page'];

    protected $dates = ['deleted_at'];

}
