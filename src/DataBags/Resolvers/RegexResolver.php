<?php

namespace ARKEcosystem\UserInterface\DataBags\Resolvers;

use ARKEcosystem\UserInterface\DataBags\Contracts\Resolver;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Spatie\Regex\Regex;

class RegexResolver implements Resolver
{
    public function resolve(array $bags, string $key)
    {
        $bag      = Arr::get($bags, $key);
        $subjects = array_keys($bag);

        foreach ($subjects as $subject) {
            if (Regex::match($subject, Request::path())->hasMatch()) {
                return $bag[$subject];
            }
        }
    }
}
