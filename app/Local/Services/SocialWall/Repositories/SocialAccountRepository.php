<?php namespace Local\Services\SocialWall\Repositories;

use InvalidArgumentException;

class SocialAccountRepository {

    protected $model;

    public function __construct(Models\SocialAccount $model)
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

    public function getByType($type = 'twitter')
    {
        $accounts = [];

        if ( ! in_array($type, ['twitter', 'instagram', 'facebook']))
        {
            throw new InvalidArgumentException('Account type is invalid [' . $type . ']');
        }

        $socialAccounts = $this->model->whereNotNull($type)->orderBy('name')->get();
        if ( ! empty($socialAccounts))
        {
            foreach ($socialAccounts as $socialAccount)
            {
                $accounts[$socialAccount->$type] = [
                    'id'    => $socialAccount->id,
                    'name'  => $socialAccount->name,
                    'metas' => $this->model->getMetas($socialAccount->id),
                ];
            }
        }

        return $accounts;
    }

}
