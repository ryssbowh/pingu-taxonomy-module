<?php

namespace Pingu\Taxonomy\Providers;

use Illuminate\Database\Eloquent\Factory;
use Pingu\Core\Support\ModuleServiceProvider;
use Pingu\Taxonomy\Entities\FieldTaxonomy;
use Pingu\Taxonomy\Entities\Taxonomy;
use Pingu\Taxonomy\Entities\TaxonomyItem;
use Pingu\Taxonomy\Validation\TaxonomyRules;

class TaxonomyServiceProvider extends ModuleServiceProvider
{
    protected $entities = [
        Taxonomy::class,
        TaxonomyItem::class
    ];

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerEntities($this->entities);
        $this->registerTranslations();
        $this->registerConfig();
        $this->loadModuleViewsFrom(__DIR__ . '/../Resources/views', 'taxonomy');
        $this->registerFactories();
        $this->extendsValidator();

        \Field::registerBundleFields(
            [
            FieldTaxonomy::class
            ]
        );
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

    protected function extendsValidator()
    {
        \Validator::extend('taxonomy_vocabulary', TaxonomyRules::class.'@vocabulary');
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
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('taxonomy.php')
        ], 'taxonomy-config');
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
