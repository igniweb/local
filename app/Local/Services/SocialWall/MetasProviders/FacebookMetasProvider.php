<?php namespace Local\Services\SocialWall\MetasProviders;

use Local\Services\SocialWall\Apis\FacebookApi;

class FacebookMetasProvider extends AbstractMetasProvider  {

    private $api;

    private $graph;

    private $picture;

    public function __construct()
    {
        $this->api = new FacebookApi(['appId' => $_ENV['FACEBOOK_ID'], 'secret' => $_ENV['FACEBOOK_SECRET']]);
    }

    public function getMetas($socialAccount)
    {
        $this->graph   = $this->getGraph($socialAccount->facebook);
        $this->picture = $this->getPicture($socialAccount->facebook);

        if ( ! empty($this->graph))
        {
            return parent::getMetas($socialAccount);
        }

        return [];
    }

    private function getGraph($account)
    {
        $data = @file_get_contents('https://graph.facebook.com/' . $account);

        return ! empty($data) ? json_decode($data) : false;
    }

    private function getPicture($account)
    {
        $data = @file_get_contents('https://graph.facebook.com/' . $account . '/picture?type=square&redirect=false');

        return ! empty($data) ? json_decode($data) : false;
    }

    protected function setAccountName($socialAccountId)
    {
        if ( ! empty($this->graph->name))
        {
            $this->metas[] = [
                'account_id' => $socialAccountId,
                'type'       => 'facebook',
                'key'        => 'account_name',
                'value'      => $this->graph->name,
            ];
        }
    }

    protected function setAccountIcon($socialAccountId)
    {
        if ( ! empty($this->picture->data->url))
        {
            $this->metas[] = [
                'account_id' => $socialAccountId,
                'type'       => 'facebook',
                'key'        => 'account_icon',
                'value'      => $this->picture->data->url,
            ];
        }
    }

    protected function setExtraMetas($socialAccount)
    {
        $this->setGraphId($socialAccount->id);
    }

    protected function setGraphId($socialAccountId)
    {
        if ( ! empty($this->graph->id))
        {
            $this->metas[] = [
                'account_id' => $socialAccountId,
                'type'       => 'facebook',
                'key'        => 'graph_id',
                'value'      => $this->graph->id,
            ];
        }
    }

}
