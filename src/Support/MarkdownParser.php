<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Support;

use tidy;
use DOMAttr;
use DOMNodeList;
use DOMDocument;
use DOMXPath;
use Illuminate\Support\Arr;
use League\CommonMark\MarkdownConverterInterface;
use Exception;


final class MarkdownParser
{
    private static array $validUserTagsAndAttributes = [
        'div' => [],
        'span' => [],
        'h2' => [],
        'h3' => [],
        'h4' => [],
        'ins' => [],
        'i' => [],
        'a' => ['href',],
        'p' => [],
        'br' => [],
        'ul' => [],
        'ol' => [],
        'li' => [],
        'strong' => [],
        'b' => [],
        'em' => [],
        'i' => [],
        'img' => ['src', 'alt'],
        'del' => [],
        'strike' => [],
        'blockquote' => [],
        'table' => [],
        'tbody' => [],
        'thead' => [],
        'tr' => [],
        'td' => [],
        'code' => [],
        'pre' => [],
    ];

    private static array $basicAllowedTags = [
        'a',
        'p',
        'br',
        'ul',
        'ol',
        'li',
        // bold variants
        'strong',
        'b',
        // italic variants
        'em',
        'i',
    ];

    private static array $fullAllowedTags = [
        'h2',
        'h3',
        'h4',
        'a',
        'p',
        'br',
        'ul',
        'ol',
        'li',
        'blockquote',
        'table',
        'tbody',
        'thead',
        'pre',
        'code',
        'tr',
        'td',
        // underline variants
        'ins',
        'u',
        // bold variants
        'strong',
        'b',
        // italic variants
        'em',
        'i',
        // strile variants
        'del',
        'strike',
    ];

    private MarkdownConverterInterface $markdownConverter;

    public function __construct()
    {
        $this->markdownConverter = resolve(MarkdownConverterInterface::class);
    }

    public function getMarkdownCoverter(): MarkdownConverterInterface
    {
        return $this->markdownConverter;
    }

    public static function basic(string | null $text): string
    {
        if ($text === null) {
            return '';
        }

        // Encodes the header symbols (`#`) so they are not converted to HTML
        $text = static::encodeMarkdownHeaders($text);

        $cleanHTML = static::getHtml($text);

        $basicHtml = static::removeUnallowedHTMLTags($cleanHTML, static::$basicAllowedTags);

        return $basicHtml;
    }

    public static function full(string | null $text): string
    {
        if ($text === null) {
            return '';
        }

        $cleanHTML = static::getHtml($text);

        $fullHtml = static::removeUnallowedHTMLTags($cleanHTML, static::$fullAllowedTags);

        return $fullHtml;
    }

    /**
     * The HTML converter keeps the line breaks (`\n`) that are inside a
     * HTML tag like a paragraph (`<p>`). This method replaces every line break
     * for the HTML `<br />` tag.
     */
    private static function replaceLineBreaksInsideTagsForBr(string $text): string
    {
        $regex = '/<(p|a|strong|b|em|i|li|ins|h2|h3|h4|td)\b(?:[^>]*)>(?:\s|\S)*?<\/\1>/m';

        preg_match_all($regex, $text, $matches, PREG_SET_ORDER, 0);

        foreach ($matches as $match) {
            $replaced = preg_replace('/\r\n|\r|\n/', '<br />', $match[0]);
            $text = str_replace($match[0], $replaced, $text);
        }

        return $text;
    }

    /**
     * Replaces every paragraph HTML Tag for the markdown equivalent (two break
     * lines)
     */
    private static function replaceParagraphsForMarkdown(string $text): string
    {
        // Any text inside a <p>
        $regex = '/<p\b[^>]*>((?:\s|\S)*?)<\/p>\s*/m';

        // Adds two break lines
        $substitution = "$1\n\n";

        return preg_replace($regex, $substitution, $text);
    }

    /**
     * Searchs for every HTML `simple` tag (a, strong, etc) and wraps it in a
     * paragraph (`p`) in order to have normalized data
     */
    private static function wrapBasicTagsInAParagraph(string $text): string
    {
        $regex = '/<((?:a|strong|b|em|i|li|ins))\b([^>]*)>((?:\s|\S)*?)<\/\1>\s*/m';

        $substitution = "<p><$1$2>$3</$1></p>";

        return preg_replace($regex, $substitution, $text);
    }

    /**
     * Searchs for every HTML `img` tag and wraps it in a paragraph (`p`) in order
     * to have normalized data
     */
    private static function wrapImagesTagsInAParagraph(string $text): string
    {
        // Any text inside a <p>
        $regex = '/<img\b([^>]*)\/>/m';

        // Adds two break lines
        $substitution = "<p><img$1/></p>";

        return preg_replace($regex, $substitution, $text);
    }

    /**
     * Normalizes and prepares both HTML and markdown to be converted to HTML
     */
    private static function normalizeHTMLAndMarkdown(string $text): string
    {
        $markdown = static::wrapBasicTagsInAParagraph($text);

        $markdown = static::wrapImagesTagsInAParagraph($markdown);

        return static::replaceParagraphsForMarkdown($markdown);
    }

    private static function convertMarkdownToHtml(string $markdown): string
    {
        // This method is called twice in purpose. This first time to convert
        // every `\n` that is inside a **user** HTML tags to `<br />`, otherwise
        // the markdown converter make them a <p> that breaks the HTML.
        // The second time is called is at the end of this same method once
        // the markdown is already converted to HTML.
        $markdown = static::replaceLineBreaksInsideTagsForBr($markdown);

        $html = (new static)->getMarkdownCoverter()->convertToHtml($markdown);

        return static::replaceLineBreaksInsideTagsForBr($html);
    }

    private static function removeUnallowedHTMLTags(string $html, array $tags): string
    {
        $allowedTagsStr = '<' . implode('><', $tags) . '>';

        return strip_tags($html, $allowedTagsStr);
    }

    private static function cleanHtml(string $html): string
    {
        $html = static::removeUnallowedHTMLTags($html, array_keys(static::$validUserTagsAndAttributes));

        $html = static::removeUnallowedHTMLAttributes($html);

        return $html;
    }

    private static function getHtml(string $text): string
    {
        $markdown = static::normalizeHTMLAndMarkdown($text);

        $html = static::convertMarkdownToHtml($markdown);

        $safeHtml = static::cleanHtml($html);

        return $safeHtml;
    }

    private static function encodeMarkdownHeaders(string $text): string
    {
        return str_replace('#', '&#35;', $text);
    }

    private static function removeUnallowedHTMLAttributes(string $html): string
    {
        $dom = new DOMDocument;
        try {
            $dom->loadHTML($html);
        } catch (Exception $e) {
            return '';
        }

        $attributes = static::getAttributesNodes($dom);

        collect($attributes)
            ->filter(fn ($attribute) => static::isAttributeAllowedForTag($attribute))
            ->each(fn($node) => $node->parentNode->removeAttribute($node->nodeName));

        $tidy = new tidy();

        return $tidy->repairString($dom->saveHTML(), [
            'output-xhtml' => true,
            'show-body-only' => true,
        ], 'utf8');
    }

    private static function getAttributesNodes(DOMDocument $dom): DOMNodeList
    {
        $xpath = new DOMXPath($dom);
        return $xpath->query('//@*');
    }

    private static function isAttributeAllowedForTag(DOMAttr $attribute): bool
    {
        return !in_array(
            $attribute->nodeName,
            Arr::get(static::$validUserTagsAndAttributes, $attribute->parentNode->tagName, [])
        );
    }
}
