<?php

namespace ARKEcosystem\UserInterface\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Lang;
use PragmaRX\Google2FALaravel\Facade as Google2FA;

class OneTimePassword implements Rule
{
    private string $secret;

    public function __construct(string $secret)
    {
        $this->secret = $secret;
    }

    public function passes($attribute, $value)
    {
        try {
            return Google2FA::verifyKey($this->secret, $value);
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function message()
    {
        return Lang::get('validation.messages.one_time_password');
    }
}
