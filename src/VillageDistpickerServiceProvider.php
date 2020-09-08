<?php

namespace Dcat\Admin\Extension\VillageDistpicker;

use Illuminate\Support\ServiceProvider;

class VillageDistpickerServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $extension = VillageDistpicker::make();

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, VillageDistpicker::NAME);
        }

        if ($lang = $extension->lang()) {
            $this->loadTranslationsFrom($lang, VillageDistpicker::NAME);
        }

        if ($migrations = $extension->migrations()) {
            $this->loadMigrationsFrom($migrations);
        }

        $this->app->booted(function () use ($extension) {
            $extension->routes(__DIR__.'/../routes/web.php');
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
    }
}
