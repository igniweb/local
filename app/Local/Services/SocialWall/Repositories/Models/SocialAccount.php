<?php namespace Local\Services\SocialWall\Repositories\Models;

use Eloquent;
use Illuminate\Database\Eloquent\SoftDeletingTrait;

class SocialAccount extends Eloquent {

    use SoftDeletingTrait;

    public $table = 'social_accounts';

    protected $fillable = ['name', 'slug', 'twitter', 'instagram', 'facebook'];

    protected $dates = ['deleted_at'];

    public function getMetas($accountId)
    {
        $metas = [];

        $socialAccountMetas = DB::table('social_account_metas')->select('key', 'value')->where('account_id', '=', $accountId)->orderBy('key')->get();
        foreach ($socialAccountMetas as $socialAccountMeta)
        {
            $metas[$socialAccountMeta->key] = $socialAccountMeta->value;
        }

        return $metas;
    }

}
