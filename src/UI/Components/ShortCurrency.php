<?php

namespace ARKEcosystem\UserInterface\Components;

use Closure;
use Illuminate\View\Component;
use ARKEcosystem\UserInterface\NumberFormatter\NumberFormatter;

final class ShortCurrency extends Component
{
    private string $currency;

    public function __construct(string $currency)
    {
        $this->currency = $currency;
    }

    public function render(): Closure
    {
        return function (array $data): string {
            return NumberFormatter::new()->formatWithCurrencyShort((float) trim((string) $data['slot']), $this->currency);
        };
    }
}
