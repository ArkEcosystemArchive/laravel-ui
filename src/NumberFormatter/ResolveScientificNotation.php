<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\NumberFormatter;

final class ResolveScientificNotation
{
    public static function execute(float $float): string
    {
        $parts = explode('E', strtoupper((string) $float));

        if (count($parts) === 2) {
            $exp     = abs((float) end($parts)) + strlen($parts[0]);
            $decimal = number_format($float, (int) $exp);

            return strval(rtrim($decimal, '.0'));
        }

        return strval($float);
    }
}
