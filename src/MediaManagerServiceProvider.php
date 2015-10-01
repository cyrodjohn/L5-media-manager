<?php namespace Joanvt\MediaManager;

use Illuminate\Support\ServiceProvider;

class MediaManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
			__DIR__.'/../database/migrations' => database_path('migrations'),
		]);
    }
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
		
    }
    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
    
}