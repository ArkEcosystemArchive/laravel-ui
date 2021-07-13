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
        $markdownParser = new self;

        $text = $markdownParser->encodeMarkdownHeaders($text);

        $html = $markdownParser->getMarkdownCoverter()->convertToHtml($text);

        return $markdownParser->stripUnalllowedTags($html);
    }

    public static function full(string | null $text): string
    {
        if ($text === null) {
            return '';
        }

        return (new self)->getMarkdownCoverter()->convertToHtml($text);
    }

    private function encodeMarkdownHeaders(string $text): string
    {
        return str_replace('#', '&#35;', $text);
    }

    private function stripUnalllowedTags(string $html): string
    {
        return strip_tags(
            $html,
            ['a', 'p', 'br', 'ul', 'ol', 'li', 'strong', 'em', 'svg', 'g', 'path', 'div', 'span'],
        );
    }
}
