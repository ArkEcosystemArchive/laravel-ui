<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\DataBags\Resolvers\Concerns;

use Illuminate\Support\Arr;

trait InteractsWithBag
{
    private function resolveFromBag(array $bags, string $key, string $path)
    {
        if (Arr::has($bags, "$key.$path")) {
            return Arr::get($bags, "$key.$path");
        }

        return Arr::get($bags, "$key.*");
    }
}
