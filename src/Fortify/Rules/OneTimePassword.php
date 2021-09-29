<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use Illuminate\Contracts\Validation\Rule;
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
        return trans('fortify::validation.messages.one_time_password');
    }
}
