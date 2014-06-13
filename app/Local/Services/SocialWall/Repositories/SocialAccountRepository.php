<?php namespace Local\Services\SocialWall\Repositories;

use InvalidArgumentException;

class SocialAccountRepository {

    protected $model;

    public function __construct(Models\SocialAccount $model)
    {
        $this->model = $model;
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

        $socialAccounts = $this->model->with('metas')->whereNotNull($type)->orderBy('name')->get();
        if ( ! empty($socialAccounts))
        {
            foreach ($socialAccounts as $socialAccount)
            {
                $account = $socialAccount->toArray();
                $metas   = ! empty($account['metas']) ? $account['metas'] : [];

                $account['metas'] = [];
                foreach ($metas as $meta)
                {
                    if ($meta['type'] == $type)
                    {
                        $account['metas'][$meta['key']] = $meta['value'];
                    }
                }

                $accounts[$socialAccount->$type] = $account;
            }
        }

        return $accounts;
    }

    public function getById()
    {
        $accounts = [];

        $socialAccounts = $this->model->with('metas')->orderBy('id')->get();
        if ( ! empty($socialAccounts))
        {
            foreach ($socialAccounts as $socialAccount)
            {
                $account = $socialAccount->toArray();
                $metas   = ! empty($account['metas']) ? $account['metas'] : [];

                $account['metas'] = [];
                foreach ($metas as $meta)
                {
                    $account['metas'][$meta['type']][$meta['key']] = $meta['value'];
                }

                $accounts[$socialAccount->id] = $account;
            }
        }

        return $accounts;
    }

}
