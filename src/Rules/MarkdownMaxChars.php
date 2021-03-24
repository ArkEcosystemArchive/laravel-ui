<?php

namespace ARKEcosystem\UserInterface\Rules;

use Illuminate\Contracts\Validation\Rule;
use ARKEcosystem\UserInterface\Support\MarkdownParser;

class MarkdownMaxChars implements Rule
{
    private int $maxChars;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $maxChars)
    {
        $this->maxChars = $maxChars;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $text = $this->getText($value);

        return mb_strlen($text) <= $this->maxChars;
    }

    private function getText($value): string
    {
        $html = $this->getHtml($value);

        $html = $this->removeHeadersAnchors($html);

        return strip_tags($html);
    }

    private function removeHeadersAnchors($html): string
    {
        $regex = '/<a\s?[^>]*[^>]*>#<\/a>/siU';
        return preg_replace($regex, '', $html);
    }

    private function getHtml($value): string
    {
        return MarkdownParser::full($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('ui::validation.custom.max_markdown_chars', ['max' => $this->maxChars]);
    }
}
