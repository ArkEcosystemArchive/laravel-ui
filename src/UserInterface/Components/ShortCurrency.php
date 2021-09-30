<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components;

use ARKEcosystem\Foundation\NumberFormatter\NumberFormatter;
use Closure;
use Illuminate\View\Component;

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
