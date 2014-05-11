<?php namespace bonaccorsop\RoleThemAll;

use Illuminate\Support\ServiceProvider;


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
        $this->package( 'bonaccorsop/rolethemall', 'bonaccorsop/rolethemall' );

        require_once __DIR__ . '/../../filters.php';

        //facade it
        $this->app->bind( 'Role', function() {
            return new Role( new RolesParser( new ConfigLoader ) );
        } );

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // let's bind the interfaces to the implementations
        //$app = $this->app;

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