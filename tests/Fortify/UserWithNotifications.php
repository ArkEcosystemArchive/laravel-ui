<?php

declare(strict_types=1);

namespace Tests\Fortify;

use ARKEcosystem\Foundation\Fortify\Models\User;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class UserWithNotifications extends User
{
    use Notifiable;

    protected $table = 'users';

    public static function fake(): self
    {
        return static::create([
            'name'              => 'John Doe',
            'username'          => 'john.doe',
            'email'             => 'john@doe.com',
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token'    => Str::random(10),
            'timezone'          => 'UTC',
        ]);
    }
}
