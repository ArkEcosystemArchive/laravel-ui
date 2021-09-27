<?php

namespace ARKEcosystem\UserInterface\Providers;

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
