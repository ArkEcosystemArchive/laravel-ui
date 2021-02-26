<?php

use ARKEcosystem\UserInterface\Components\SvgLazy;

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
    function alertIcon(string $type, bool $rounded): string
    {
        if (in_array($type, ['success', 'error', 'danger', 'hint', 'warning', 'info'])) {
            if ($rounded) {
                return "alert-{$type}";
            } else {
                return [
                    'success' => 'success',
                    'error' => 'danger',
                    'danger' => 'danger',
                    'hint' => 'question-mark',
                    'warning' => 'exclamation-mark',
                    'info' => 'info'
                ][$type];
            }
        } else {
            return $rounded ? "alert-info" : "info";
        }
    }
}