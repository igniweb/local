<?php namespace Local\Services\SocialWall\MetasProviders;

use Local\Services\SocialWall\Apis\InstagramApi;

class InstagramMetasProvider extends AbstractMetasProvider  {

    private $api;

    private $user;

    public function __construct()
    {
        $this->api = new InstagramApi;
    }

    public function getMetas($socialAccount)
    {
        $this->user = $this->getUser($socialAccount->instagram);

        if ( ! empty($this->user))
        {
            return parent::getMetas($socialAccount);
        }

        return [];
    }

    private function getUser($account)
    {
        $data = $this->api->query('users/search', ['q' => $account]);

        return ! empty($data[0]) ? $data[0] : false;
    }

    protected function setAccountName($socialAccountId)
    {
        if ( ! empty($this->user->full_name))
        {
            $this->metas[] = [
                'account_id' => $socialAccountId,
                'type'       => 'instagram',
                'key'        => 'account_name',
                'value'      => $this->user->full_name,
            ];
        }
    }

    protected function setAccountIcon($socialAccountId)
    {
        if ( ! empty($this->user->profile_picture))
        {
            $this->metas[] = [
                'account_id' => $socialAccountId,
                'type'       => 'instagram',
                'key'        => 'account_icon',
                'value'      => $this->user->profile_picture,
            ];
        }
    }

    protected function setExtraMetas($socialAccount)
    {
        $this->setUserId($socialAccount->id);
    }

    private function setUserId($socialAccountId)
    {
        if ( ! empty($this->user->id))
        {
            $this->metas[] = [
                'account_id' => $socialAccountId,
                'type'       => 'instagram',
                'key'        => 'user_id',
                'value'      => $this->user->id,
            ];
        }
    }

}
