<?php

declare(strict_types=1);

namespace Tests;

use ARKEcosystem\Foundation\Fortify\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Str;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Illuminate\View\ComponentAttributeBag;

function createAttributes(array $attributes): array
{
    $defaults = [
        'name'   => 'username',
        'errors' => new ViewErrorBag(),
    ];

    return array_merge([
        'attributes' => new ComponentAttributeBag(array_merge($defaults, $attributes)),
    ], $defaults, $attributes);
}

function createViewAttributes(array $attributes): array
{
    return array_merge([
        'attributes' => new ComponentAttributeBag($attributes),
    ], $attributes);
}

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
