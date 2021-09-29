<?php

declare(strict_types=1);

namespace ARKEcosystem\CommonMark\Extensions\Image;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Element\Image;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;
use League\CommonMark\Util\ConfigurationAwareInterface;
use League\CommonMark\Util\ConfigurationInterface;
use League\CommonMark\Util\RegexHelper;

final class ImageRenderer implements InlineRendererInterface, ConfigurationAwareInterface
{
    /**
     * @var ConfigurationInterface
     */
    protected $config;

    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer): HtmlElement
    {
        if (! ($inline instanceof Image)) {
            throw new \InvalidArgumentException('Incompatible inline type: '.\get_class($inline));
        }

        $attrs = $inline->getData('attributes', []);

        $forbidUnsafeLinks = $this->config->get('allow_unsafe_links', true) !== true;
        if ($forbidUnsafeLinks && RegexHelper::isLinkPotentiallyUnsafe($inline->getUrl())) {
            $attrs['src'] = '';
        } else {
            $attrs['src'] = $inline->getUrl();
        }

        $alt          = $htmlRenderer->renderInlines($inline->children());
        $alt          = \preg_replace('/\<[^>]*alt="([^"]*)"[^>]*\>/', '$1', $alt);
        $attrs['alt'] = \preg_replace('/\<[^>]*\>/', '', $alt);

        /* @phpstan-ignore-next-line */
        if (isset($inline->data['title'])) {
            $attrs['title'] = $inline->data['title'];
        }

        $url = MediaUrlParser::parse($inline->getUrl());

        if ($url !== null) {
            if ($url->isSimpleCast()) {
                $content = SimpleCastRenderer::render($url);
            } elseif ($url->isTwitter()) {
                $content = TwitterRenderer::render($url);
            } elseif ($url->isYouTube()) {
                $content = YouTubeRenderer::render($url);
            } else {
                $content = new HtmlElement('img', $attrs, '', true);
            }
        } else {
            $content = new HtmlElement('img', $attrs, '', true);
        }

        return ContainerRenderer::render($content, $attrs['alt']);
    }

    public function setConfiguration(ConfigurationInterface $configuration)
    {
        $this->config = $configuration;
    }
}
