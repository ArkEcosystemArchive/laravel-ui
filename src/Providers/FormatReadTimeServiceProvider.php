<?php

namespace ARKEcosystem\UserInterface\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Spatie\Flash\Flash;

class FormatReadTimeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Blade::directive('formatReadTime', function ($minutes) {
            return "<?php echo '$minutes: '.$minutes; ?>";

            $readTime = (new \DateTime())->setTime(0, (int) $minutes);

            echo sprintf(
                "%s %s",
                trans_choice("ui::general.time.hour", (int) $readTime->format("H"), ["value" => (int) $readTime->format("H")]),
                trans_choice("ui::general.time.min", (int) $readTime->format("i"), ["value" => (int) $readTime->format("i")])
            );

            /*return sprintf(
                '<?php
                    $readTime = (new \DateTime())->setTime(0, %s);

                    echo sprintf(
                        "%%s %%s",
                        trans_choice("ui::general.time.hour", (int) $readTime->format("H"), ["value" => (int) $readTime->format("H")]),
                        trans_choice("ui::general.time.min", (int) $readTime->format("i"), ["value" => (int) $readTime->format("i")])
                    );
                ?>',
                $minutes
            );*/
        });
    }
}
