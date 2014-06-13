<?php namespace Local\Services\SocialWall\MetasProviders;

use Local\Services\SocialWall\MetasProviderInterface;
use Patchwork\Utf8;

abstract class AbstractMetasProvider implements MetasProviderInterface {

    protected $metas = [];

    public function getMetas($socialAccount)
    {
        $this->setAccountName($socialAccount->id);

        $this->setAccountIcon($socialAccount->id);

        $this->setExtraMetas($socialAccount);

        return $this->metas;
    }

    abstract protected function setAccountName($socialAccountId);

    abstract protected function setAccountIcon($socialAccountId);

    abstract protected function setExtraMetas($socialAccount);

    protected function clean($str)
    {
        return Utf8::utf8_encode(Utf8::utf8_decode($str));
    }

}