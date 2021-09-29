<?php

declare(strict_types=1);

namespace ARKEcosystem\CommonMark\Extensions\Image;

use League\CommonMark\HtmlElement;

final class YouTubeRenderer
{
    public static function render(MediaUrl $url): HtmlElement
    {
        $video = new HtmlElement('iframe', [
            'width'           => '100%',
            'height'          => 480,
            'src'             => 'https://www.youtube.com/embed/'.$url->getId(),
            'frameborder'     => 0,
            'allowfullscreen' => 1,
            // Noise
            'showinfo'        => 0,
            'controls'        => 0,
            'autoplay'        => 0,
            'modestbranding'  => 1,
            'autohide'        => 1,
        ]);

        $container = new HtmlElement('div', ['class' => 'video-container']);
        $container->setContents($video);

        return $container;
    }
}
