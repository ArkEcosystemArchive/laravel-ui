<?php

use ARKEcosystem\UserInterface\Components\SvgLazy;

if (! function_exists('svgLazy')) {
    function svgLazy(string $name, $class = ''): SvgLazy
    {
        return new SvgLazy($name, $class);
    }
}
