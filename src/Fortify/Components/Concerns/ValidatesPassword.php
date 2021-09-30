<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components\Concerns;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

trait ValidatesPassword
{
    public array $passwordRules = [
        'lowercase'  => false,
        'uppercase'  => false,
        'numbers'    => false,
        'symbols'    => false,
        'min'        => false,
        'leak'       => false,
    ];

    public function updatedPassword($password)
    {
        if (is_null($password)) {
            return;
        }

        $this->passwordRules['lowercase'] = $password && (bool) preg_match('/\p{Ll}/u', $password);
        $this->passwordRules['uppercase'] = $password && (bool) preg_match('/\p{Lu}/u', $password);
        $this->passwordRules['min']       = $this->passes(Password::min(12), $password);
        $this->passwordRules['numbers']   = $this->passes(Password::min(0)->numbers(), $password);
        $this->passwordRules['symbols']   = $this->passes(Password::min(0)->symbols(), $password);
        $this->passwordRules['leak']      = $this->passes(Password::min(8)->uncompromised(0)->symbols(), $password);

        if (! $this->passwordRules['leak']) {
            $this->addError('password', trans('fortify::validation.password_leaked'));
        }
    }

    private function passes(Rule $rule, string $password): bool
    {
        if (! $password) {
            return false;
        }

        $validator = Validator::make(['password' => $password], [
            'password' => $rule,
        ]);

        return $validator->passes();
    }

    private function resetRules(): void
    {
        foreach (array_keys($this->passwordRules) as $ruleName) {
            $this->passwordRules[$ruleName] = false;
        }
    }
}
