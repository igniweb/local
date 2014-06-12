<?php namespace Local\Services\SocialWall\Repositories;

use InvalidArgumentException;

class SocialUserRepository {

    protected $model;

    public function __construct(Models\SocialUser $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->orderBy('name')->get();
    }

    public function findById($id)
    {
        return $this->model->findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return $this->model->where('slug', '=', $slug)->firstOrFail();
    }

    public function getAccounts($type = 'twitter')
    {
        $accounts = [];

        if ( ! in_array($type, ['twitter', 'instagram', 'facebook']))
        {
            throw new InvalidArgumentException('Account type is invalid [' . $type . ']');
        }

        $socialUsers = $this->model->whereNotNull($type)->orderBy('name')->get();
        if ( ! empty($socialUsers))
        {
            foreach ($socialUsers as $socialUser)
            {
                $accounts[$socialUser->$type] = [
                    'id'   => $socialUser->id,
                    'name' => $socialUser->name,
                ];
                if (($type == 'facebook') and ! empty($socialUser->facebook_page))
                {
                    $accounts[$socialUser->$type]['page_id'] = $socialUser->facebook_page;
                }
            }
        }

        return $accounts;
    }

}
