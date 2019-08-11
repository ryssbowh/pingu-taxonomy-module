<?php

namespace Pingu\Taxonomy\Providers;

use Illuminate\Database\Eloquent\Factory;
use Pingu\Core\Support\ModuleServiceProvider;

class TaxonomyServiceProvider extends ModuleServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /*
     * Where are the models located
     */
    protected $modelFolder = 'Entities';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerModelSlugs(__DIR__.'/../'.$this->modelFolder);
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'taxonomy');
        $this->registerFactories();
        //$this->registerAssets();
    }

    /**
     * Register js and css for this module
     */
    public function registerAssets()
    {
        \Asset::container('modules')->add('taxonomy-js', 'module-assets/Taxonomy.js');
        \Asset::container('modules')->add('taxonomy-css', 'module-assets/Taxonomy.css');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'taxonomy'
        );
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/taxonomy');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'taxonomy');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'taxonomy');
        }
    }

    /**
     * Register an additional directory of factories.
     * 
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
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
