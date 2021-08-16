<?php

use ARKEcosystem\UserInterface\Components\SvgLazy;
use Illuminate\Support\Collection;

if (! function_exists('svgLazy')) {
    function svgLazy(string $name, $class = ''): SvgLazy
    {
        return new SvgLazy($name, $class);
    }
}

if (! function_exists('formatReadTime')) {
    function formatReadTime(int $minutes): string
    {
        $readTime = (new DateTime())->setTime(0, $minutes);

        return sprintf(
            '%s %s',
            trans_choice('generic.time.hour', (int) $readTime->format('H'), ['value' => (int) $readTime->format('H')]),
            trans_choice('generic.time.min', (int) $readTime->format('i'), ['value' => (int) $readTime->format('i')])
        );
    }
}

if (! function_exists('alertIcon')) {
    function alertIcon(string $type): string
    {
        if (in_array($type, ['success', 'error', 'danger', 'hint', 'warning', 'info'])) {
            return [
                'success' => 'checkmark-smooth',
                'error'   => 'errored',
                'danger'  => 'errored',
                'hint'    => 'question-mark',
                'warning' => 'exclamation-mark',
                'info'    => 'info'
            ][$type];
        }

        return "info";
    }
}

if (! function_exists('clearZalgoText')) {
    function clearZalgoText(string $zalgo): string
    {
        return preg_replace("|[\p{M}]|uis","", $zalgo);
    }
}
