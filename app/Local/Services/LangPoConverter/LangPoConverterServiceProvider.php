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
        return ['local.commands.lang-to-po'];
    }

    private function registerCommands()
    {
        $this->app['local.commands.lang-to-po'] = $this->app->share(function($app)
        {
            return new Commands\LangToPoCommand(
                new Converters\LangToPoConverter(
                    new Converters\Parsers\LangParser,
                    new Converters\Writers\PoWriter($app['config']['workbench'])
                )
            );
        });
        $this->commands('local.commands.lang-to-po');
    }

}
