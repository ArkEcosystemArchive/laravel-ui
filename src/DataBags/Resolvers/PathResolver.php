<?php

namespace ARKEcosystem\UserInterface\DataBags\Resolvers;

use ARKEcosystem\UserInterface\DataBags\Contracts\Resolver;
use Illuminate\Support\Facades\Request;

class PathResolver implements Resolver
{
    use Concerns\InteractsWithBag;

    public function resolve(array $bags, string $key)
    {
        return $this->resolveFromBag($bags, $key, Request::path());
    }
}
