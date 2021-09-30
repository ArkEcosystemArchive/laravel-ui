<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class FormatReadTimeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('formatReadTime', function ($expression) {
            return "<?php echo e(formatReadTime($expression)->render()); ?>";
        });
    }
}
