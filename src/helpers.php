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
                'error'   => 'cross',
                'danger'  => 'cross',
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

if (! function_exists('extractSlidesBreakpoints')) {
    function extractSlidesBreakpoints(string $str): Collection
    {
        $data = [
            'slidesPerGroup' => '/(?<breakpoint>\d+):\s{[^}]*(?>slidesPerGroup:\s+(?<slidesPerGroup>\d+))[^}]*}/m',
            'slidesPerView' => '/(?<breakpoint>\d+):\s{[^}]*(?>slidesPerView:\s+(?<slidesPerView>\d+))[^}]*}/m',
            'slidesPerColumn' => '/(?<breakpoint>\d+):\s{[^}]*(?>slidesPerColumn:\s+(?<slidesPerColumn>\d+))[^}]*}/m',
            'slidesPerColumnFill' => '/(?<breakpoint>\d+):\s{[^}]*(?>slidesPerColumnFill:\s+\'(?<slidesPerColumnFill>[^\']+))[^}]*}/m',
        ];


        return collect($data)->mapWithKeys(function ($regex, $name) use ($str) {
            preg_match_all($regex, $str, $matches, PREG_SET_ORDER, 0);

            $result = collect($matches)->mapWithKeys(function ($match) use ($name) {
                return [$match['breakpoint'] =>  $match[$name]];
            });

            return [$name => $result];
        });
    }
}
