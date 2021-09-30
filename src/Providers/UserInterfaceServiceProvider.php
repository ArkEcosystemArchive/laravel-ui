<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use Livewire\Livewire;
use Spatie\Flash\Flash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use ARKEcosystem\Foundation\UserInterface\UI;
use ARKEcosystem\Foundation\UserInterface\Components\Toast;
use ARKEcosystem\Foundation\UserInterface\Components\Number;
use ARKEcosystem\Foundation\UserInterface\Components\DataBag;
use ARKEcosystem\Foundation\UserInterface\Components\Currency;
use ARKEcosystem\Foundation\UserInterface\Components\HoneyPot;
use ARKEcosystem\Foundation\UserInterface\Components\Percentage;
use ARKEcosystem\Foundation\UserInterface\Components\FlashMessage;
use ARKEcosystem\Foundation\UserInterface\Components\ShortCurrency;
use ARKEcosystem\Foundation\UserInterface\Components\TruncateMiddle;
use ARKEcosystem\Foundation\UserInterface\Components\ShortPercentage;
use ARKEcosystem\Foundation\UserInterface\Http\Controllers\WysiwygControlller;
use ARKEcosystem\Foundation\UserInterface\Http\Controllers\ImageCropController;

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

        $this->registerRoutes();

        UI::bootErrorMessages();
    }

    /**
     * Register the loaders.
     *
     * @return void
     */
    public function registerLoaders(): void
    {
        $this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'ui');
    }

    /**
     * Register routes.
     *
     * @return void
     */
    public function registerRoutes(): void
    {
        Route::group(['prefix' => 'wysiwyg'], function () {
            Route::get('twitter-embed-code', [WysiwygControlller::class, 'getTwitterEmbedCode'])->name('wysiwyg.twitter');
            Route::post('upload-image', [WysiwygControlller::class, 'uploadImage'])->name('wysiwyg.upload-image')->middleware(['web', 'auth']);
            Route::post('count-characters', [WysiwygControlller::class, 'countCharacters'])->name('wysiwyg.count-characters')->middleware(['web', 'auth', 'throttle']);
        });

        Route::post('cropper/upload-image', ImageCropController::class)->name('cropper.upload-image')->middleware(['web', 'auth']);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    private function registerPublishers(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'ark');

        $this->publishes([
            __DIR__.'/../../config/ui.php' => config_path('ui.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__.'/../../config/ui.php',
            'ui'
        );

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/ark'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../../resources/views/pagination.blade.php'     => resource_path('views/vendor/ark/pagination.blade.php'),
            __DIR__.'/../../resources/views/pagination-url.blade.php' => resource_path('views/vendor/ark/pagination-url.blade.php'),
        ], 'pagination');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/markdown-editor' => resource_path('js/vendor/ark/markdown-editor'),
        ], 'wysiwyg');

        $this->publishes([
            __DIR__.'/../../resources/assets/fonts' => resource_path('fonts'),
        ], 'fonts');

        $this->publishes([
            __DIR__.'/../../resources/assets/css' => resource_path('css/vendor/ark'),
        ], 'css');

        $this->publishes([
            __DIR__.'/../../resources/assets/icons' => resource_path('icons'),
        ], 'icons');

        $this->publishes([
            __DIR__.'/../../resources/assets/images/components' => resource_path('images/vendor/ark'),
        ], 'images');

        $this->publishes([
            __DIR__.'/../../resources/views/errors'         => resource_path('views/errors'),
            __DIR__.'/../../resources/assets/images/errors' => resource_path('images/errors'),
        ], 'error-pages');

        // Individual JS files

        $this->publishes([
            __DIR__.'/../../resources/assets/js/modal.js' => resource_path('js/vendor/ark/modal.js'),
        ], 'modal');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/page-scroll.js' => resource_path('js/vendor/ark/page-scroll.js'),
        ], 'page-scroll');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/rich-select.js' => resource_path('js/vendor/ark/rich-select.js'),
        ], 'tippy');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/prism-line-numbers.js' => resource_path('js/vendor/ark/prism-line-numbers.js'),
            __DIR__.'/../../resources/assets/js/prism.js'              => resource_path('js/vendor/ark/prism.js'),
        ], 'prism');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/clipboard.js' => resource_path('js/vendor/ark/clipboard.js'),
        ], 'clipboard');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/reposition-dropdown.js' => resource_path('js/vendor/ark/reposition-dropdown.js'),
        ], 'dropdown');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/highlightjs-copy.js' => resource_path('js/vendor/ark/highlightjs-copy.js'),
        ], 'highlightjs');

        $this->publishes([
            __DIR__.'/../../resources/assets/js/file-download.js' => resource_path('js/vendor/ark/file-download.js'),
        ], 'file-download');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    private function registerBladeComponents(): void
    {
        $this->callAfterResolving(BladeCompiler::class, function (BladeCompiler $blade) {
            $blade->component('ark::inputs.checkbox', 'ark-checkbox');
            $blade->component('ark::inputs.date-picker', 'ark-date-picker');
            $blade->component('ark::inputs.input', 'ark-input');
            $blade->component('ark::inputs.input-with-icon', 'ark-input-with-icon');
            $blade->component('ark::inputs.input-with-prefix', 'ark-input-with-prefix');
            $blade->component('ark::inputs.input-with-suffix', 'ark-input-with-suffix');
            $blade->component('ark::inputs.radio', 'ark-radio');
            $blade->component('ark::inputs.textarea', 'ark-textarea');
            $blade->component('ark::inputs.toggle', 'ark-toggle');
            $blade->component('ark::inputs.select', 'ark-select');
            $blade->component('ark::inputs.upload', 'ark-upload');
            $blade->component('ark::inputs.password-toggle', 'ark-password-toggle');
            $blade->component('ark::inputs.rich-select', 'ark-rich-select');
            $blade->component('ark::inputs.markdown', 'ark-markdown');
            $blade->component('ark::inputs.user-tagger', 'ark-user-tagger');
            $blade->component('ark::inputs.switch', 'ark-switch');
            $blade->component('ark::inputs.tile-selection', 'ark-tile-selection');
            $blade->component('ark::inputs.time', 'ark-time');
            $blade->component('ark::inputs.upload-image-single', 'ark-upload-image-single');
            $blade->component('ark::inputs.upload-image-collection', 'ark-upload-image-collection');
            $blade->component('ark::inputs.tags', 'ark-tags');

            $blade->component('ark::pages.contact.content', 'ark-pages-contact-content');
            $blade->component('ark::pages.contact.header', 'ark-pages-contact-header');

            $blade->component('ark::pages.includes.markdown-scripts', 'ark-pages-includes-markdown-scripts');
            $blade->component('ark::pages.includes.crop-image-scripts', 'ark-pages-includes-crop-image-scripts');
            $blade->component('ark::pages.includes.compress-image-scripts', 'ark-pages-includes-compress-image-scripts');

            $blade->component('ark::tables.table', 'ark-tables.table');
            $blade->component('ark::tables.row', 'ark-tables.row');
            $blade->component('ark::tables.cell', 'ark-tables.cell');
            $blade->component('ark::tables.header', 'ark-tables.header');
            $blade->component('ark::tables.view-options', 'ark-tables.view-options');
            $blade->component('ark::tables.mobile.cell', 'ark-tables.mobile.cell');
            $blade->component('ark::tables.mobile.row', 'ark-tables.mobile.row');

            $blade->component('ark::accordion-group', 'ark-accordion-group');
            $blade->component('ark::accordion', 'ark-accordion');
            $blade->component('ark::alert', 'ark-alert');
            $blade->component('ark::alert-simple', 'ark-alert-simple');
            $blade->component('ark::avatar', 'ark-avatar');
            $blade->component('ark::breadcrumbs', 'ark-breadcrumbs');
            $blade->component('ark::clipboard', 'ark-clipboard');
            $blade->component('ark::code', 'ark-code');
            $blade->component('ark::code-lines', 'ark-code-lines');
            $blade->component('ark::container', 'ark-container');
            $blade->component('ark::description-block', 'ark-description-block');
            $blade->component('ark::description-block-link', 'ark-description-block-link');
            $blade->component('ark::details-box', 'ark-details-box');
            $blade->component('ark::details-box-mobile', 'ark-details-box-mobile');
            $blade->component('ark::divider', 'ark-divider');
            $blade->component('ark::dropdown', 'ark-dropdown');
            $blade->component('ark::expandable', 'ark-expandable');
            $blade->component('ark::expandable-item', 'ark-expandable-item');
            $blade->component('ark::external-link', 'ark-external-link');
            $blade->component('ark::external-link-confirm', 'ark-external-link-confirm');
            $blade->component('ark::flash', 'ark-flash');
            $blade->component('ark::footer-bar-desktop', 'ark-footer-bar-desktop');
            $blade->component('ark::footer-bar-mobile', 'ark-footer-bar-mobile');
            $blade->component('ark::footer-copyright', 'ark-footer-copyright');
            $blade->component('ark::footer-social', 'ark-footer-social');
            $blade->component('ark::footer', 'ark-footer');
            $blade->component('ark::horizontal-divider', 'ark-horizontal-divider');
            $blade->component('ark::icon', 'ark-icon');
            $blade->component('ark::icon-link', 'ark-icon-link');
            $blade->component('ark::image-tile', 'ark-image-tile');
            $blade->component('ark::info', 'ark-info');
            $blade->component('ark::js-modal', 'ark-js-modal');
            $blade->component('ark::local-time', 'ark-local-time');
            $blade->component('ark::logo', 'ark-logo');
            $blade->component('ark::logo-simple', 'ark-logo-simple');
            $blade->component('ark::loading-spinner', 'ark-loading-spinner');
            $blade->component('ark::spinner-icon', 'ark-spinner-icon');
            $blade->component('ark::loader-icon', 'ark-loader-icon');
            $blade->component('ark::message', 'ark-message');
            $blade->component('ark::metadata', 'ark-metadata');
            $blade->component('ark::metadata-tags', 'ark-metadata-tags');
            $blade->component('ark::modal', 'ark-modal');
            $blade->component('ark::no-results', 'ark-no-results');
            $blade->component('ark::notification-dot', 'ark-notification-dot');
            $blade->component('ark::outgoing-link', 'ark-outgoing-link');
            $blade->component('ark::pagination', 'ark-pagination');
            $blade->component('ark::pagination-url', 'ark-pagination-url');
            $blade->component('ark::read-more', 'ark-read-more');
            $blade->component('ark::secondary-menu', 'ark-secondary-menu');
            $blade->component('ark::sidebar-link', 'ark-sidebar-link');
            $blade->component('ark::simple-footer', 'ark-simple-footer');
            $blade->component('ark::slider-slide', 'ark-slider-slide');
            $blade->component('ark::slider', 'ark-slider');
            $blade->component('ark::social-link', 'ark-social-link');
            $blade->component('ark::social-square', 'ark-social-square');
            $blade->component('ark::sort-icon', 'ark-sort-icon');
            $blade->component('ark::status-circle', 'ark-status-circle');
            $blade->component('ark::svg-lazy', 'ark-svg-lazy');
            $blade->component('ark::toast', 'ark-toast');
            $blade->component('ark::shapes.line', 'ark-placeholder-line');
            $blade->component('ark::shapes.square', 'ark-placeholder-square');
            $blade->component('ark::link-collection', 'ark-link-collection');
            $blade->component('ark::file-download', 'ark-file-download');
            $blade->component('ark::chart', 'ark-chart');
            $blade->component('ark::tabs.wrapper', 'ark-tabbed');
            $blade->component('ark::tabs.tab', 'ark-tab');
            $blade->component('ark::tabs.panel', 'ark-tab-panel');

            // Navigation
            $blade->component('ark::navbar', 'ark-navbar');
            $blade->component('ark::navbar.link-mobile', 'ark-navbar-link-mobile');
            $blade->component('ark::navbar.hamburger', 'ark-navbar-hamburger');

            // Font Loader
            $blade->component('ark::font-loader', 'ark-font-loader');

            // Honey Pot
            $blade->component('honey-pot', HoneyPot::class);

            // Formatting
            $blade->component('currency', Currency::class);
            $blade->component('number', Number::class);
            $blade->component('percentage', Percentage::class);
            $blade->component('short-currency', ShortCurrency::class);
            $blade->component('short-percentage', ShortPercentage::class);
            $blade->component('truncate-middle', TruncateMiddle::class);

            // Data Bags
            $blade->component('data-bag', DataBag::class);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    private function registerLivewireComponents(): void
    {
        Livewire::component('flash-message', FlashMessage::class);
        Livewire::component('toast', Toast::class);
    }
}
