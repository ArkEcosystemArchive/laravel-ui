<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Rules;

use Illuminate\Contracts\Validation\Rule;

final class StartsWithLetterOrNumber implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Start with a (unicode) letter or a number
        $regex = '/^(\p{L}|\p{N}).*$/u';

        return preg_match($regex, $value) > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('ui::validation.messages.start_with_letter_or_number');
    }
}
