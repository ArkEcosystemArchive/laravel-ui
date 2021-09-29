<?php

namespace ARKEcosystem\UserInterface\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;

class StrongPassword implements Rule
{
    public function passes($attribute, $value): bool
    {
        return preg_match("/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@()$%^&*=_{}[\]:;\"'|\\<>,.\/~`±§+-]).{12,128}$/", $value);
    }

    public function message()
    {
        return Lang::get('validation.messages.strong_password');
    }
}
