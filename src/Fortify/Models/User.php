<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends UserWithoutVerification implements MustVerifyEmail
{
    //
}
