<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules\Concerns;

abstract class BaseRule
{
    abstract public static function passes($attribute, $value): bool;

    abstract public static function message(array $attributes = []): string;
}
