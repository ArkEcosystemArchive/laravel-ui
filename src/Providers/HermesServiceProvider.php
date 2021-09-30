<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use ARKEcosystem\Hermes\Components\ManageNotifications;
use ARKEcosystem\Hermes\Components\NotificationsIndicator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class HermesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../../config/hermes.php', 'hermes');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerLoaders();

        $this->registerPublishers();

        $this->registerBladeComponents();

        $this->registerLivewireComponents();
    }

    /**
     * Register the loaders.
     *
     * @return void
     */
    public function registerLoaders(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'hermes');

        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'hermes');
    }

    /**
     * Register the publishers.
     *
     * @return void
     */
    public function registerPublishers(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../../config/hermes.php' => config_path('hermes.php'),
            ], 'hermes-config');

            $this->publishes([
                __DIR__.'/../../resources/views/components' => resource_path('views/components'),
            ], 'hermes-views');

            $this->publishes([
                __DIR__.'/../../database/migrations' => database_path('migrations'),
            ], 'hermes-migrations');
        }
    }

    /**
     * Register the Blade components.
     *
     * @return void
     */
    public function registerBladeComponents(): void
    {
        Blade::component('hermes::navbar-notifications', 'hermes-navbar-notifications');
        Blade::component('hermes::notification-icon', 'hermes-notification-icon');
    }

    /**
     * Register the Livewire components.
     *
     * @return void
     */
    public function registerLivewireComponents(): void
    {
        Livewire::component('manage-notifications', ManageNotifications::class);
        Livewire::component('notifications-indicator', NotificationsIndicator::class);
    }
}
