<?php

namespace Tests;

use ARKEcosystem\CommonMark\CommonMarkServiceProvider;
use GrahamCampbell\Markdown\MarkdownServiceProvider;
use Illuminate\Support\Facades\View;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * @coversNothing
 */
class TestCase extends Orchestra
{
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
            MarkdownServiceProvider::class,
            CommonMarkServiceProvider::class,
        ];
    }
}
