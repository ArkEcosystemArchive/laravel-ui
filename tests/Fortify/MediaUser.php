<?php

declare(strict_types=1);

namespace Tests;

use ARKEcosystem\Fortify\Models\User;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class MediaUser extends User implements HasMedia
{
    use InteractsWithMedia;

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
