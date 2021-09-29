<?php

namespace ARKEcosystem\UserInterface\Components;

use Closure;
use Illuminate\View\Component;
use ARKEcosystem\UserInterface\NumberFormatter\NumberFormatter;

final class ShortPercentage extends Component
{
    public function render(): Closure
    {
        return function (array $data): string {
            return NumberFormatter::new()->formatWithPercent((float) trim((string) $data['slot']), 0);
        };
    }
}
