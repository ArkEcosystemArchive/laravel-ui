<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Support\Facades\View;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;
use Spatie\Newsletter\NewsletterServiceProvider;
use GrahamCampbell\Markdown\MarkdownServiceProvider;
use ARKEcosystem\Foundation\Providers\HermesServiceProvider;
use ARKEcosystem\Foundation\Providers\FortifyServiceProvider;
use ARKEcosystem\Foundation\Providers\CommonMarkServiceProvider;
use ARKEcosystem\Foundation\Providers\UserInterfaceServiceProvider;
use Laravel\Fortify\FortifyServiceProvider as LaravelFortifyServiceProvider;

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
            CommonMarkServiceProvider::class,
            FortifyServiceProvider::class,
            HermesServiceProvider::class,
            LaravelFortifyServiceProvider::class,
            LivewireServiceProvider::class,
            MarkdownServiceProvider::class,
            NewsletterServiceProvider::class,
            UserInterfaceServiceProvider::class,

        ];
    }
}
