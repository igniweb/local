<?php namespace Local\Services\SocialWall\MetasProviders;

use Thujohn\Twitter\Twitter as TwitterApi;

class TwitterMetasProvider extends AbstractMetasProvider  {

    private $api;

    private $user;

    public function __construct()
    {
        $this->api = new TwitterApi;
    }

    public function getMetas($socialAccount)
    {
        $this->user = $this->getUser($socialAccount->twitter);

        if ( ! empty($this->user))
        {
            return parent::getMetas($socialAccount);
        }

        return [];
    }

    private function getUser($account)
    {
        $data = $this->api->getUsers(['screen_name' => $account]);

        return ! empty($data) ? $data : false;

    }

    protected function setAccountName($socialAccountId)
    {
        if ( ! empty($this->user->name))
        {
            $this->metas[] = [
                'account_id' => $socialAccountId,
                'type'       => 'twitter',
                'key'        => 'account_name',
                'value'      => $this->clean($this->user->name),
            ];
        }
    }

    protected function setAccountIcon($socialAccountId)
    {
        if ( ! empty($this->user->profile_image_url))
        {
            $this->metas[] = [
                'account_id' => $socialAccountId,
                'type'       => 'twitter',
                'key'        => 'account_icon',
                'value'      => $this->user->profile_image_url,
            ];
        }
    }

    protected function setExtraMetas($socialAccount)
    {
        //
    }

}
