<?php namespace Zofe\Rapyd;
use Illuminate\Html\FormBuilder;
use Illuminate\Html\HtmlBuilder;
use Illuminate\Support\ServiceProvider;
class RapydServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
			__DIR__.'/../database/migrations' => base_path('database/migrations'),
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