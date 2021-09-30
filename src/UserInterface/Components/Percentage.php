<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components;

use ARKEcosystem\Foundation\NumberFormatter\NumberFormatter;
use Closure;
use Illuminate\View\Component;

final class Percentage extends Component
{
    public function render(): Closure
    {
        return function (array $data): string {
            return NumberFormatter::new()->formatWithPercent((float) trim((string) $data['slot']), 2);
        };
    }
}
