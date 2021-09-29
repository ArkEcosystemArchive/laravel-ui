<?php

declare(strict_types=1);

namespace Tests;

use ARKEcosystem\Fortify\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

function createUserModel(string $userClass = User::class)
{
    return $userClass::create([
        'name'              => 'John Doe',
        'username'          => 'john.doe',
        'email'             => 'john@doe.com',
        'email_verified_at' => Carbon::now(),
        'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        'remember_token'    => Str::random(10),
        'timezone'          => 'UTC',
    ]);
}

function expectValidationError(Closure $callback, string $key, string $reason)
{
    try {
        $callback();
    } catch (ValidationException $exception) {
        expect($exception->validator->errors()->has($key))->toBeTrue();
        expect($exception->validator->errors()->get($key))->toContain($reason);
    }
}
