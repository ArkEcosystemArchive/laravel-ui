<?php

namespace ARKEcosystem\UserInterface\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;

class FormatReadTimeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('formatReadTime', function ($expression) {
            return "<?php echo e(formatReadTime($expression)->render()); ?>";
        });
    }
}
