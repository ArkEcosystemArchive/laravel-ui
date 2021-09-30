<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class SvgLazyServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('svgLazy', function ($expression) {
            return "<?php echo e(svgLazy($expression)->render()); ?>";
        });
    }
}
