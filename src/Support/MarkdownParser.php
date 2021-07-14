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

    private static array $replaced = [];

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

        $html = static::getHtml($text);

        $html = static::removeUnallowedHTMLTags($html, static::$basicAllowedTags);

        return static::rollbackMarkdownComponents($html);
    }

    public static function full(string | null $text): string
    {
        if ($text === null) {
            return '';
        }


        $html = static::getHtml($text);

        $html = static::removeUnallowedHTMLTags($html, static::$basicAllowedTags);

        return static::rollbackMarkdownComponents($html);

    }

    /**
     * The HTML converter keeps the line breaks (`\n`) that are inside a
     * HTML tag like a paragraph (`<p>`). This method replaces every line break
     * for the HTML `<br />` tag.
     */
    private static function replaceLineBreaksInsideTagsForBr(string $text): string
    {
        $regex = '/<(p|a|strong|b|em|i|li|ins|h2|h3|h4|td)\b(?:[^>]*)>[^\s*<](?:\s|\S)*?<\/\1>/m';

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

        $markdown = static::replaceLineBreaksInsideTagsForBr($markdown);

        return static::replaceParagraphsForMarkdown($markdown);
    }

    private static function convertMarkdownToHtml(string $markdown): string
    {
        $html = (new static)->getMarkdownCoverter()->convertToHtml($markdown);

        return static::replaceLineBreaksInsideTagsForBr($html);
    }

    private static function removeUnallowedHTMLTags(string $html, array $tags): string
    {
        $allowedTagsStr = '<' . implode('><', $tags) . '>';

        return strip_tags($html, $allowedTagsStr);
    }

    private static function temporaryStripAndStoreMarkdownComponents(string $html): string
    {
        // Currently we only have the LinkRenderer
        $componentsRegexs = [
            'linkRenderedRegex' => '/<div\s*x-data="{\s*openModal\(\)\s*{\s*Livewire\.emit\(\'openModal\', \'[a-f0-9]{32}\'\)\s*},\s*redirect\(\)\s*{\s*window.open\(\'[A-Za-z0-9-,._~:\/?#\[\]@!\$&\(\)\*\+ ;%="]*\', \'_blank\'\)\s*},\s*hasDisabledLinkWarning\(\)\s*{\s*return localStorage\.getItem\(\'has_disabled_link_warning\'\) === \'true\';\s*}\s*}"\s*class="inline-block items-center space-x-2 font-semibold break-all cursor-pointer link"\s*>\s*<a\s*:href="hasDisabledLinkWarning\(\) \? \'[A-Za-z0-9-,._~:\/?#\[\]@!\$&\(\)\*\+ ;%="]*\'\s:\s\'javascript:;\'"\s*:target="hasDisabledLinkWarning\(\) \? \'_blank\' : \'_self\'"\s*rel="noopener nofollow"\s*class="inline-flex items-center space-x-2 font-semibold whitespace-nowrap cursor-pointer link"\s*@click="hasDisabledLinkWarning\(\) \? redirect\(\) : openModal\(\)"\s*>\s*<span>[^<>"\'`]*<\/span>\s*(?:<svg[^>]*>.*<\/svg>)?\s*<\/a>\s*<\/div>/m'
        ];

        foreach ($componentsRegexs as $regex) {
            preg_match_all($regex, $html, $matches, PREG_SET_ORDER, 0);

            // For every found component, we store it on the temporary array so
            // it can be recovered untoched at the end of the process
            foreach ($matches as $match) {
                $id = md5($match[0]);
                static::$replaced[$id] = $match[0];
                $html = str_replace($match[0], '[' . $id . ']', $html);
            }
        }

        return $html;
    }

    private static function rollbackMarkdownComponents(string $html): string
    {
        foreach(static::$replaced as $id => $originalHTML)
        {
            $html = str_replace('<p>[' . $id . ']</p>', $originalHTML, $html);
        }

        return $html;
    }

    private static function cleanHtml(string $html): string
    {
        $html = static::temporaryStripAndStoreMarkdownComponents($html);

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

        dd($html);

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
