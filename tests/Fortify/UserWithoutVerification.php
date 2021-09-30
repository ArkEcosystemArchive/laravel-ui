<?php

declare(strict_types=1);

namespace Tests\Fortify;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserWithoutVerification extends Authenticatable
{
    protected $table = 'users';

    protected $guarded = false;

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
