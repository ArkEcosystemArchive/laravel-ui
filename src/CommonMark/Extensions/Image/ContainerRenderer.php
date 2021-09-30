<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\CommonMark\Extensions\Image;

use League\CommonMark\HtmlElement;

final class ContainerRenderer
{
    /** @phpstan-ignore-next-line */
    public static function render($content, $title): HtmlElement
    {
        /* @phpstan-ignore-next-line */
        if (empty($title)) {
            return $content;
        }

        $container = new HtmlElement('div', ['class' => 'image-container'], '', true);
        $title     = new HtmlElement('span', ['class' => 'image-caption'], $title, true);

        return $container->setContents([$content, $title]);
    }
}
