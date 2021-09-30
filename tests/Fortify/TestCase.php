<?php

declare(strict_types=1);

namespace Tests;

use ARKEcosystem\Fortify\FortifyServiceProvider;
use ARKEcosystem\Foundation\UserInterface\UserInterfaceServiceProvider;
use Laravel\Fortify\FortifyServiceProvider as LaravelFortifyServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Newsletter\NewsletterServiceProvider;

/**
 * @coversNothing
 */
class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            UserInterfaceServiceProvider::class,
            LaravelFortifyServiceProvider::class,
            FortifyServiceProvider::class,
            NewsletterServiceProvider::class,
        ];
    }
}
