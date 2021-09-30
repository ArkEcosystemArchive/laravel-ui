<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Actions\UpdateUserProfileInformation;
use function Tests\createUserModel;
use function Tests\expectValidationError;
use Tests\Fortify\UserWithNotifications;
use Tests\Fortify\UserWithoutVerification;

it('should update the profile information', function () {
    $user = createUserModel(UserWithoutVerification::class);

    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@doe.com');

    resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => 'jane@doe.com',
    ]);

    expect($user->name)->toBe('Jane Doe');
    expect($user->email)->toBe('jane@doe.com');
});

it('should update the profile information for a user that requires verification', function () {
    $user = createUserModel(UserWithNotifications::class);

    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@doe.com');
    expect($user->email_verified_at)->not()->toBeNull();

    resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => 'jane@doe.com',
    ]);

    expect($user->name)->toBe('Jane Doe');
    expect($user->email)->toBe('jane@doe.com');
    expect($user->email_verified_at)->toBeNull();
});

it('should update with lowercase email', function () {
    $user = createUserModel(UserWithoutVerification::class);

    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@doe.com');

    resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => 'JANE@DOE.COM',
    ]);

    expect($user->name)->toBe('Jane Doe');
    expect($user->email)->toBe('jane@doe.com');
});

it('should update with lowercase email for a user that requires verification', function () {
    $user = createUserModel(UserWithNotifications::class);

    expect($user->name)->toBe('John Doe');
    expect($user->email)->toBe('john@doe.com');
    expect($user->email_verified_at)->not()->toBeNull();

    resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => 'JANE@DOE.COM',
    ]);

    expect($user->name)->toBe('Jane Doe');
    expect($user->email)->toBe('jane@doe.com');
    expect($user->email_verified_at)->toBeNull();
});

it('should throw an exception if the name is missing', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => null,
        'email' => 'jane@doe.com',
    ]), 'name', 'The name field is required.');
});

it('should throw an exception if the name is too short', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => str_repeat('a', 2),
        'email' => 'jane@doe.com',
    ]), 'name', 'The name must be at least 3 characters.');
});

it('should throw an exception if the name is too long', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'a'.str_repeat('a', 31),
        'email' => 'jane@doe.com',
    ]), 'name', 'The name must not be greater than 30 characters.');
});

it('should throw an exception if the email is missing', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => null,
    ]), 'email', 'The email field is required.');
});

it('should throw an exception if the email is too long', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => str_repeat('#', 256).'@doe.com',
    ]), 'email', 'The email must not be greater than 255 characters.');
});

it('should throw an exception if the email is not an email', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserProfileInformation::class)->update($user, [
        'name'  => 'Jane Doe',
        'email' => str_repeat('#', 256),
    ]), 'email', 'The email must be a valid email address.');
});
