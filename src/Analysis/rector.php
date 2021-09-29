<?php

declare(strict_types=1);

use Rector\Core\Configuration\Option;
use Rector\SOLID\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(Option::PATHS, [__DIR__.'/app', __DIR__.'/tests']);

    // auto import fully qualified class names? [default: false]
    $parameters->set(Option::AUTO_IMPORT_NAMES, true);

    $services = $containerConfigurator->services();
    $services->set(FinalizeClassesWithoutChildrenRector::class);
};
