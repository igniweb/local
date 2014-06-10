<?php namespace Local\Services\LangPoConverter;

use Illuminate\Support\ServiceProvider;

class LangPoConverterServiceProvider extends ServiceProvider
{

    protected $defer = false;

    public function register()
    {
        $this->registerCommands();
    }

    public function provides()
    {
        return ['local.commands.lang-to-po', 'local.commands.po-to-lang'];
    }

    private function registerCommands()
    {
        $this->app['local.commands.lang-to-po'] = $this->app->share(function($app)
        {
            return new Commands\LangToPoCommand($app['config']['workbench']);
        });
        $this->commands('local.commands.lang-to-po');

        $this->app['local.commands.po-to-lang'] = $this->app->share(function($app)
        {
            return new Commands\PoToLangCommand;
        });
        $this->commands('local.commands.po-to-lang');
    }

}
