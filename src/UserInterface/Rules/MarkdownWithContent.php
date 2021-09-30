<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Rules;

use ARKEcosystem\Foundation\UserInterface\Rules\Concerns\ValidatesEmptyString;
use ARKEcosystem\Foundation\UserInterface\Support\Concerns\ParsesMarkdown;
use Illuminate\Contracts\Validation\Rule;

class MarkdownWithContent implements Rule
{
    use ParsesMarkdown;
    use ValidatesEmptyString;

    /**
     * Determine if the validation rule passes.
     *
     * @param string      $attribute
     * @param string|null $value
     *
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
