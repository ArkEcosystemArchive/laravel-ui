<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use DOMDocument;
use DOMNodeList;
use DOMXPath;
use DOMAttr;
use Illuminate\Support\Arr;
use tidy;

final class Markdown implements CastsAttributes
{
    protected array $allowedTags = [
        'ins' => [],
        'a' => ['href'],
        'p' => [],
        'br' => [],
        'ul' => [],
        'ol' => [],
        'li' => [],
        'strong' => [],
        'b' => [],
        'em' => [],
        'i' => [],
        // 'img' => ['src', 'alt'],
    ];

    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return array
     */
    public function get($model, $key, $value, $attributes)
    {
        return $value;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param string                              $value
     * @param array                               $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes): string
    {
        $html = $this->removeUnexpectedHTMLTags($value);

        $html = $this->removeUnexpectedHTMLAttributes($html);

        return $html;
    }

    private function removeUnexpectedHTMLTags(string $html): string
    {
        $allowedTagsStr = '<' . implode('><', array_keys($this->allowedTags)) . '>';

        return rtrim(strip_tags($html, $allowedTagsStr));
    }

    private function removeUnexpectedHTMLAttributes(string $html): string
    {
        $dom = new DOMDocument;
        $dom->loadHTML($html);

        $attributes = $this->getAttributesNodes($dom);

        collect($attributes)
            ->filter(fn ($attribute) => $this->isAttributeAllowedForTag($attribute))
            ->each(fn($node) => $node->parentNode->removeAttribute($node->nodeName));

        $tidy = new tidy();

        return $tidy->repairString($dom->saveHTML(), [
            'output-xhtml' => true,
            'show-body-only' => true,
        ], 'utf8');
    }

    private function getAttributesNodes(DOMDocument $dom): DOMNodeList
    {
        $xpath = new DOMXPath($dom);
        return $xpath->query('//@*');
    }

    private function isAttributeAllowedForTag(DOMAttr $attribute): bool
    {
        return !in_array(
            $attribute->nodeName,
            Arr::get($this->allowedTags, $attribute->parentNode->tagName, [])
        );
    }
}
