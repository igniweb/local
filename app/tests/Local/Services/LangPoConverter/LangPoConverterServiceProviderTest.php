<?php namespace Local\Services\LangPoConverter;

use TestCase;

class LangPoConverterServiceProviderTest extends TestCase {

    protected $service;

    public function setUp()
    {
        parent::setUp();

        $this->service = new LangPoConverterServiceProvider($this->app);
    }

    public function testProvidesCommands()
    {
        $provided = $this->service->provides();

        $this->assertContains('local.commands.lang-to-po', $provided);
        $this->assertContains('local.commands.po-to-lang', $provided);
    }

    public function testLangToPoCommandIsLoaded()
    {
        $command = $this->app->make('local.commands.lang-to-po');

        $this->assertInstanceOf('Local\Services\LangPoConverter\Commands\LangToPoCommand', $command);
    }

    public function testPoToLangCommandIsLoaded()
    {
        $command = $this->app->make('local.commands.po-to-lang');

        $this->assertInstanceOf('Local\Services\LangPoConverter\Commands\PoToLangCommand', $command);
    }

}
