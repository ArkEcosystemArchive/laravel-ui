<?php

namespace ARKEcosystem\UserInterface\Rules;

use Illuminate\Contracts\Validation\Rule;

class Tag implements Rule
{
    public function passes($attribute, $value): bool
    {
        $regex = '/^(?=.{3,30}$)(?![0-9])[A-Za-z0-9]+$/sm';
        return preg_match($regex, $value);
    }

    public function message()
    {
        return trans('ui::validation.custom.invalid_tag');
    }
}
