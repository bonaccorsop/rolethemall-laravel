<?php namespace bonaccorsop\RoleThemAll;

use Illuminate\Support\ServiceProvider;
use bonaccorsop\RoleThemAll\Role;

class RoleServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->package( 'bonaccorsop/rolethemall-laravel', 'bonaccorsop/rolethemall-laravel' );

        require_once __DIR__ . '/../../filters.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // let's bind the interfaces to the implementations
        $app = $this->app;

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        //return array('oauth2.authorization-server', 'oauth2.resource-server');
    }
}