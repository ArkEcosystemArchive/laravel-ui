<?php

namespace ARKEcosystem\UserInterface\NumberFormatter\Concerns;

use Illuminate\Support\Str;
use ARKEcosystem\UserInterface\NumberFormatter\ResolveScientificNotation;

trait HasCustomFormatters
{
    public function formatWithCurrencyShort(int | float | string $value, string $currency): string
    {
        $i     = 0;
        $units = ['', 'K', 'M', 'B', 'T'];

        for ($i = 0; $value >= 1000; $i++) {
            $value /= 1000;
        }

        return round((float) $value, 1).$units[$i].' '.strtoupper($currency);
    }

    public function formatWithCurrencyCustom(int | float | string $value, string $currency, ?int $decimals = null): string
    {
        $result = $this->formatWithDecimal((float) $value);

        if (Str::contains((string) $value, ',')) {
            $result = $value;
        } elseif (Str::contains((string) $value, '.')) {
            $result = number_format((float) ResolveScientificNotation::execute((float) $value), $decimals ?? 8);
            $result = rtrim(rtrim($result, '0'), '.');
        }

        return rtrim($result.' '.strtoupper($currency));
    }
}
