<?php namespace Gaia\Posts;

use Illuminate\Support\ServiceProvider;

class GaiaPostsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        //publish the views 
        $this->publishes([ __DIR__ .'/../../Views' => base_path('resources/views/') ]);
        //publish the database migrations and seeds
        $this->publishes([ __DIR__ .'/../../Database' => base_path('database/') ]);
        //Publish the models
        $this->publishes([ __DIR__ .'/../../Models' => base_path('app/Models/') ]);
        //publish PSR-4 Gaia folder
        $this->publishes([ __DIR__ .'/../../PSR4' => base_path('app/') ]);
        //include the routes
        include __DIR__.'/../../routes.php';
    }


    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('Gaia\Repositories\PostTypeRepositoryInterface', 'Gaia\Repositories\PostTypeRepository');
        $this->app->bind('Gaia\Repositories\PostRepositoryInterface', 'Gaia\Repositories\PostRepository');

    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
       
    }

}