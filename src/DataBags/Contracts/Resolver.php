<?php

namespace ARKEcosystem\UserInterface\DataBags\Contracts;

interface Resolver
{
    /**
     * @return mixed
     */
    public function resolve(array $bags, string $key);
}
