<?php

namespace ARKEcosystem\UserInterface\DataBags\Resolvers;

use ARKEcosystem\UserInterface\DataBags\Contracts\Resolver;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;

class GlobResolver implements Resolver
{
    public function resolve(array $bags, string $key)
    {
        $bag      = Arr::get($bags, $key);
        $subjects = array_keys($bag);

        foreach ($subjects as $subject) {
            if (fnmatch($subject, Request::path())) {
                return $bag[$subject];
            }
        }
    }
}
