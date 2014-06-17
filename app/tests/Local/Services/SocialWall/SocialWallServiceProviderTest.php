<?php namespace Local\Services\SocialWall;

use TestCase;

class SocialWallServiceProviderTest extends TestCase {

    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new SocialWallServiceProvider($this->app);
    }

    public function testProvidesCommand()
    {
        $provided = $this->service->provides();

        $this->assertContains('local.commands.social-wall-fetch', $provided);
    }

    public function testFetchCommandIsLoaded()
    {
        $command = $this->app->make('local.commands.social-wall-fetch');

        $this->assertInstanceOf('Local\Services\SocialWall\Commands\FetchCommand', $command);
    }

}
