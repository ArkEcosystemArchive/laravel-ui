<?php

namespace ARKEcosystem\UserInterface\Rules;

use ARKEcosystem\UserInterface\Rules\Concerns\ValidatesMarkdown;
use Illuminate\Contracts\Validation\Rule;

class MarkdownWithContent implements Rule
{
    use ValidatesMarkdown;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $text = $this->stripZeroWidthSpaces($this->getText($value));

        return strlen($text) > 0;
    }

    public function stripZeroWidthSpaces(string $text): string
    {
        // Zero-width characters to remove, source: http://jkorpela.fi/chars/spaces.html
        $regex = '/[\x{2000}-\x{200D}\x{FEFF}\x{0020}\x{00A0}\x{3000}\x{205F}\x{202F}\x{00A0}\x{180B}-\x{180F}]/u';

        return preg_replace($regex, '', $text);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.required');
    }
}
