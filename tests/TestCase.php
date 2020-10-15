<?php

namespace Tests;

use ARKEcosystem\UserInterface\UserInterfaceServiceProvider;
use Livewire\LivewireServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

/**
 * @coversNothing
 */
class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            LivewireServiceProvider::class,
            UserInterfaceServiceProvider::class,
        ];
    }
}
