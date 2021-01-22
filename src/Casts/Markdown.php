<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

final class Markdown implements CastsAttributes
{
    protected array $allowedTags = ['ins'];

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
     * @param array                               $value
     * @param array                               $attributes
     *
     * @return string
     */
    public function set($model, $key, $value, $attributes): string
    {
        $allowedTagsStr = '<' . implode('><', $this->allowedTags) . '>';

        return $this->rollbackEncodedAllowedTags(htmlentities(strip_tags($value, $allowedTagsStr)));
    }

    private function rollbackEncodedAllowedTags(string $text): string
    {
        foreach ($this->allowedTags as $tag) {
            $text = str_replace('&lt;' . $tag . '&gt;', '<' . $tag . '>', $text);
            $text = str_replace('&lt;/' . $tag . '&gt;', '</' . $tag . '>', $text);
        }

        return $text;
    }
}
