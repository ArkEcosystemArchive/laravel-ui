<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Support;

final class MediaConversions
{
    public static function src($media, string $conversion): string
    {
        if (! $media->hasGeneratedConversion($conversion)) {
            return $media->getUrl();
        }

        return $media->getUrl($conversion);
    }

    public static function srcset($media, string $conversion): string
    {

        return collect([1, ...config('ui.media.srcset_sizes')])
            ->map(fn ($size) => static::getCoversionSrc($media, $conversion, $size))
            ->filter(fn($src) => (bool) $src)
            ->join(', ');
    }

    private static function getCoversionSrc($media, string $conversion, int $size): ?string
    {
        $conversionName = $size === 1 ? $conversion :  $conversion . $size  . 'x';

        if (! $media->hasGeneratedConversion($conversionName)) {
            return null;
        }

        return $media->getUrl($conversionName) . ' ' . $size . 'x';
    }
}
