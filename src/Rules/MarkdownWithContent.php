<?php

namespace ARKEcosystem\UserInterface\Rules;

use ARKEcosystem\UserInterface\Rules\Concerns\ValidatesEmptyString;
use ARKEcosystem\UserInterface\Rules\Concerns\ValidatesMarkdown;
use Illuminate\Contracts\Validation\Rule;

class MarkdownWithContent implements Rule
{
    use ValidatesMarkdown;
    use ValidatesEmptyString;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  string|null  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $text = $this->stripZeroWidthSpaces($this->getText($value));

        return strlen($text) > 0;
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
