<?php

namespace ARKEcosystem\UserInterface;

use ARKEcosystem\UserInterface\Components\FlashMessage;
use ARKEcosystem\UserInterface\Components\NotificationsIndicator;
use ARKEcosystem\UserInterface\Components\Toast;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use Spatie\Flash\Flash;

class UserInterfaceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Flash::levels([
            'info'    => 'alert-info',
            'success' => 'alert-success',
            'warning' => 'alert-warning',
            'danger'  => 'alert-danger',
            'error'   => 'alert-error',
            'hint'    => 'alert-hint',
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerLoaders();

        $this->registerPublishers();

        $this->registerBladeComponents();

        $this->registerLivewireComponents();

        UI::bootErrorMessages();
    }

    /**
     * Register the loaders.
     *
     * @return void
     */
    public function registerLoaders(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'ui');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    private function registerPublishers(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'ark');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/ark'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../resources/views/livewire/notifications-indicator.blade.php' => resource_path('views/livewire/notifications-indicator.blade.php'),
            __DIR__.'/Livewire/NotificationsIndicator.php'                           => app_path('../Domain/Components/NotificationsIndicator.php'),
        ], 'notifications-indicator');

        $this->publishes([
            __DIR__.'/../resources/views/pagination.blade.php'     => resource_path('views/vendor/ark/pagination.blade.php'),
            __DIR__.'/../resources/views/pagination-url.blade.php' => resource_path('views/vendor/ark/pagination-url.blade.php'),
        ], 'pagination');

        $this->publishes([
            __DIR__.'/../resources/assets/css' => resource_path('css/vendor/ark'),
        ], 'css');

        $this->publishes([
            __DIR__.'/../resources/assets/icons' => resource_path('icons'),
        ], 'icons');

        $this->publishes([
            __DIR__.'/../resources/assets/fonts' => resource_path('fonts'),
        ], 'fonts');

        $this->publishes([
            __DIR__.'/../resources/assets/js' => resource_path('js/vendor/ark'),
        ], 'js');

        $this->publishes([
            __DIR__.'/../resources/views/errors'         => resource_path('views/errors'),
            __DIR__.'/../resources/assets/images/errors' => resource_path('images/errors'),
        ], 'error-pages');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    private function registerBladeComponents(): void
    {
        Blade::component('ark::inputs.checkbox', 'ark-checkbox');
        Blade::component('ark::inputs.input', 'ark-input');
        Blade::component('ark::inputs.input-with-icon', 'ark-input-with-icon');
        Blade::component('ark::inputs.radio', 'ark-radio');
        Blade::component('ark::inputs.textarea', 'ark-textarea');
        Blade::component('ark::inputs.toggle', 'ark-toggle');
        Blade::component('ark::inputs.select', 'ark-select');
        Blade::component('ark::inputs.upload', 'ark-upload');
        Blade::component('ark::inputs.password-toggle', 'ark-password-toggle');

        Blade::component('ark::accordion-group', 'ark-accordion-group');
        Blade::component('ark::accordion', 'ark-accordion');
        Blade::component('ark::alert', 'ark-alert');
        Blade::component('ark::alert-simple', 'ark-alert-simple');
        Blade::component('ark::avatar', 'ark-avatar');
        Blade::component('ark::breadcrumbs', 'ark-breadcrumbs');
        Blade::component('ark::clipboard', 'ark-clipboard');
        Blade::component('ark::code', 'ark-code');
        Blade::component('ark::code-lines', 'ark-code-lines');
        Blade::component('ark::description-block', 'ark-description-block');
        Blade::component('ark::description-block-link', 'ark-description-block-link');
        Blade::component('ark::dropdown', 'ark-dropdown');
        Blade::component('ark::external-link', 'ark-external-link');
        Blade::component('ark::flash', 'ark-flash');
        Blade::component('ark::footer-bar-desktop', 'ark-footer-bar-desktop');
        Blade::component('ark::footer-bar-mobile', 'ark-footer-bar-mobile');
        Blade::component('ark::footer-copyright', 'ark-footer-copyright');
        Blade::component('ark::footer-social', 'ark-footer-social');
        Blade::component('ark::horizontal-divider', 'ark-horizontal-divider');
        Blade::component('ark::icon', 'ark-icon');
        Blade::component('ark::icon-link', 'ark-icon-link');
        Blade::component('ark::image-tile', 'ark-image-tile');
        Blade::component('ark::logo', 'ark-logo');
        Blade::component('ark::logo-simple', 'ark-logo-simple');
        Blade::component('ark::loading-spinner', 'ark-loading-spinner');
        Blade::component('ark::message', 'ark-message');
        Blade::component('ark::modal', 'ark-modal');
        Blade::component('ark::navbar', 'ark-navbar');
        Blade::component('ark::notification-icon', 'ark-notification-icon');
        Blade::component('ark::outgoing-link', 'ark-outgoing-link');
        Blade::component('ark::pagination', 'ark-pagination');
        Blade::component('ark::pagination-url', 'ark-pagination-url');
        Blade::component('ark::secondary-menu', 'ark-secondary-menu');
        Blade::component('ark::sidebar-link', 'ark-sidebar-link');
        Blade::component('ark::simple-footer', 'ark-simple-footer');
        Blade::component('ark::slider-slide', 'ark-slider-slide');
        Blade::component('ark::slider', 'ark-slider');
        Blade::component('ark::social-link', 'ark-social-link');
        Blade::component('ark::social-square', 'ark-social-square');
        Blade::component('ark::status-circle', 'ark-status-circle');
        Blade::component('ark::svg-lazy', 'ark-svg-lazy');
        Blade::component('ark::toast', 'ark-toast');
        Blade::component('ark::shapes.line', 'ark-placeholder-line');
        Blade::component('ark::shapes.square', 'ark-placeholder-square');
        Blade::component('ark::link-collection', 'ark-link-collection');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    private function registerLivewireComponents(): void
    {
        Livewire::component('flash-message', FlashMessage::class);
        Livewire::component('notifications-indicator', NotificationsIndicator::class);
        Livewire::component('toast', Toast::class);
    }
}
