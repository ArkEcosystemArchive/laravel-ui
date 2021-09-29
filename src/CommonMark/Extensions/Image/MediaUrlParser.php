<?php

declare(strict_types=1);

namespace ARKEcosystem\CommonMark\Extensions\Image;

final class MediaUrlParser
{
    /**
     * @param string $url
     *
     * @return MediaUrl
     */
    public static function parse(string $url): ?MediaUrl
    {
        try {
            [$type, $id] = explode(':', $url);

            return new MediaUrl($type, $id);
        } catch (\Throwable $th) {
            return new MediaUrl(null, null);
        }
    }
}
