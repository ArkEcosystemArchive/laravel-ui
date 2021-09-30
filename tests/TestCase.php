<?php

declare(strict_types=1);

namespace Tests;

use ARKEcosystem\Foundation\Providers\CommonMarkServiceProvider;
use ARKEcosystem\Foundation\Providers\FortifyServiceProvider;
use ARKEcosystem\Foundation\Providers\HermesServiceProvider;
use ARKEcosystem\Foundation\Providers\UserInterfaceServiceProvider;
use GrahamCampbell\Markdown\MarkdownServiceProvider;
use Illuminate\Support\Facades\View;
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

    protected function defineEnvironment($app)
    {
        $app['config']->set('markdown', [
            'inlineRenderers' => [],
        ]);
        $app['config']->set('app', [
            'url' => 'https://ourapp.com',
        ]);

        View::addNamespace('ark', realpath(__DIR__.'/views'));
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelFortifyServiceProvider::class,
            MarkdownServiceProvider::class,
            CommonMarkServiceProvider::class,
            FortifyServiceProvider::class,
            HermesServiceProvider::class,
            LivewireServiceProvider::class,
            NewsletterServiceProvider::class,
            UserInterfaceServiceProvider::class,
        ];
    }
}
