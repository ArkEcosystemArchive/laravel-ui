<?php

declare(strict_types=1);

namespace ARKEcosystem\Stan;

use Illuminate\Support\ServiceProvider;

final class StanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPublishers();
    }

    /**
     * Register the publishers.
     *
     * @return void
     */
    public function registerPublishers(): void
    {
        $this->publishes([
            __DIR__ . '/../../stubs/.php-cs-fixer.php' => base_path('.php-cs-fixer.php'),
            __DIR__.'/../../stubs/phpstan.neon' => base_path('phpstan.neon'),
            __DIR__.'/../../stubs/phpunit.xml'  => base_path('phpunit.xml'),
        ], 'config');

        $this->publishes([
            __DIR__.'/../../stubs/.github' => base_path('.github'),
        ], 'workflows');
    }
}
