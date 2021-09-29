<?php

namespace ARKEcosystem\UserInterface\Components;

use Closure;
use Illuminate\View\Component;
use ARKEcosystem\UserInterface\NumberFormatter\NumberFormatter;

final class Number extends Component
{
    public function render(): Closure
    {
        return function (array $data): string {
            return NumberFormatter::new()->formatWithDecimal((float) trim((string) $data['slot']));
        };
    }
}
