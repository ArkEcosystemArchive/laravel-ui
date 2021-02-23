<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Support;

use League\CommonMark\MarkdownConverterInterface;

final class MarkdownParser
{
    private MarkdownConverterInterface $markdownConverter;

    public function __construct()
    {
        $this->markdownConverter = resolve(MarkdownConverterInterface::class);
    }

    public function getMarkdownCoverter(): MarkdownConverterInterface
    {
        return $this->markdownConverter;
    }

    public static function basic(string $text): string
    {
        $markdownConverter = new self;

        $rawHTML = $markdownConverter->getMarkdownCoverter()->convertToHtml($text);

        $rawHTMLWithTagsAsParagraphs = $markdownConverter->convertHeadersToParagraphs($rawHTML);

        return $markdownConverter->stripUnalllowedTags($rawHTMLWithTagsAsParagraphs);
    }

    public static function full(string $text): string
    {
        return (new self)->getMarkdownCoverter()->convertToHtml($text);
    }

    private function convertHeadersToParagraphs(string $html): string
    {
        $regex = '/<(h1|h2|h3|h4|h5|h6)\b[^>]*>(.*?)<\/\1>/mis';

        $rawHTMLWithTagsAsParagraphs = preg_replace($regex, '<p>$2</p>', $html);

        return $this->removeHeaderAnchors($rawHTMLWithTagsAsParagraphs);
    }

    private function removeHeaderAnchors(string $html): string
    {
        return preg_replace('/<a.*?\>#<\/a>/', '', $html);
    }

    private function stripUnalllowedTags(string $html): string
    {
        return strip_tags(
            $html,
            ['a', 'p', 'br', 'ul', 'ol', 'li', 'strong', 'em']
        );
    }
}
