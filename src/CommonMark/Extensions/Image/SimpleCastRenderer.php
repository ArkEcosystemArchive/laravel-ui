<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Image;

use League\CommonMark\HtmlElement;

final class SimpleCastRenderer
{
    public static function render(MediaUrl $url): HtmlElement
    {
        return new HtmlElement('iframe', [
            'class'       => 'w-full',
            'frameborder' => 'no',
            'scrolling'   => 'no',
            'src'         => 'https://player.simplecast.com/'.$url->getId().'?dark=false',
        ]);
    }
}
