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

    /**
     * The HTML string that the LinkRenderer componente creates (with regex on
     * the dynamic content)
     * @TODO: case where no SVG
     * @TODO: fix regex for link content
     */
    protected static string $linkRendererTemplate = <<<EOD
    <span x-data="{
        openModal() {
            Livewire.emit('openModal', '[a-f0-9]{32}')
        },
        redirect() {
            window.open('[A-Za-z0-9-,._~:/?#\[\]@!\$&\(\)\*\+ ;%="]*', '_blank')
        },
        hasDisabledLinkWarning() {
            return localStorage.getItem('has_disabled_link_warning') === 'true';
        }
    }"
        class="inline-block items-center space-x-2 font-semibold break-all cursor-pointer link"
    >
        <a
            :href="hasDisabledLinkWarning() ? '[A-Za-z0-9-,._~:/?#\[\]@!\$&\(\)\*\+ ;%="]*' : 'javascript:;'"
            :target="hasDisabledLinkWarning() ? '_blank' : '_self'"
            rel="noopener nofollow"
            class="inline-flex items-center space-x-2 font-semibold whitespace-nowrap cursor-pointer link"
            @click="hasDisabledLinkWarning() ? redirect() : openModal()"
        >
            <span>[A-Za-z0-9-,._~:/?#\[\]@!\$&\(\)\*\+ ;%="]*</span>
            <svg wire:key="[a-zA-Z0-9]*" class="fill-current w-4 h-4 inline flex-shrink-0 mr-2 ml-1 -mt-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <path d="M23.251 7.498V.748h-6.75m6.75 0l-15 15m3-10.5h-9a1.5 1.5 0 00-1.5 1.5v15a1.5 1.5 0 001.5 1.5h15a1.5 1.5 0 001.5-1.5v-9" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
            </svg>
        </a>
    </span>
EOD;

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

        $html = static::removeUnallowedHTMLTags($html, static::$fullAllowedTags);

        return static::rollbackMarkdownComponents($html);

    }

    /**
     * The HTML converter keeps the line breaks (`\n`) that are inside a
     * HTML tag like a paragraph (`<p>`). This method replaces every line break
     * for the HTML `<br />` tag.
     */
    private static function replaceLineBreaksInsideTagsForBr(string $text): string
    {
        $regex = '/<(p|a|strong|b|em|i|li|ins|h2|h3|h4|td)\b(?:[^>]*)>[^<]*<\/\1>/m';

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

    private static function buildRegexFromTemplate($template)
    {
        // Replaces a group of white-space chars with a single regex
        $template = preg_replace('/(\s+)/m', '\\\\s*', $template);
        // Escape every `/`
        $template = str_replace('/', '\/', $template);
        // Escape every `(`
        $template = str_replace('(', '\(', $template);
        // Escape every `)`
        $template = str_replace(')', '\)', $template);
        // Escape every `?`
        $template = str_replace('?', '\?', $template);

        return '/\s*' . $template . '/m';
    }


    private static function temporaryStripAndStoreMarkdownComponents(string $html): string
    {
        $componentsRegexs = [
            'linkRenderedRegex' => self::buildRegexFromTemplate(static::$linkRendererTemplate)
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

            $html = str_replace('[' . $id . ']', $originalHTML, $html);
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

        try {
            // Needs a XML encoding declaration to ensure is treated as UTF-8
            $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);
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
