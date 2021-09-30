<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;

class CurrentPassword implements Rule
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function passes($attribute, $value)
    {
        return Hash::check($value, $this->user->password);
    }

    public function message()
    {
        return Lang::get('validation.messages.current_password');
    }
}
