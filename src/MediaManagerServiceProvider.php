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
		//assets
        $this->publishes([__DIR__.'/../public/assets' => public_path('jmedia/assets')], 'assets');
		
		//config
        $this->publishes([__DIR__.'/../config/jmedia.php' => config_path('jmedia.php')], 'config');
        $this->mergeConfigFrom( __DIR__.'/../config/jmedia.php', 'jmedia');
		
		
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