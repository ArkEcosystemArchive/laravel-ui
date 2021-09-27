<?php

namespace ARKEcosystem\UserInterface\Components;

use Closure;
use Illuminate\View\Component;
use Konceiver\BetterNumberFormatter\BetterNumberFormatter;

final class Number extends Component
{
    public function render(): Closure
    {
        return function (array $data): string {
            return BetterNumberFormatter::new()->formatWithDecimal((float) trim((string) $data['slot']));
        };
    }
}
