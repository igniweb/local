<?php namespace Local\Services\SocialWall;

use Illuminate\Support\ServiceProvider;
use Local\Services\SocialWall\Repositories\Models\SocialUser;
use Local\Services\SocialWall\Repositories\SocialUserRepository;

class SocialWallServiceProvider extends ServiceProvider {

    protected $defer = false;

    public function register()
    {
        $this->registerCommands();
    }

    public function provides()
    {
        return ['local.commands.social-wall-fetch'];
    }

    private function registerCommands()
    {
        $this->app['local.commands.social-wall-fetch'] = $this->app->share(function($app)
        {
            return new Commands\FetchCommand(new SocialUserRepository(new SocialUser));
        });
        $this->commands('local.commands.social-wall-fetch');
    }

}
