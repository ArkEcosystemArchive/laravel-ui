<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Actions;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected static function passwordRules()
    {
        return [
            'required',
            'string',
            Password::min(12)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
            'confirmed',
        ];
    }
}
