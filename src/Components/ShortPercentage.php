<?php

namespace ARKEcosystem\UserInterface\Components;

use Closure;
use Illuminate\View\Component;
use Konceiver\BetterNumberFormatter\BetterNumberFormatter;

final class ShortPercentage extends Component
{
    public function render(): Closure
    {
        return function (array $data): string {
            return BetterNumberFormatter::new()->formatWithPercent((float) trim((string) $data['slot']), 0);
        };
    }
}
