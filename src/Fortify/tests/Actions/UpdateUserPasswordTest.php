<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Actions\UpdateUserPassword;
use Illuminate\Contracts\Validation\UncompromisedVerifier;
use function Tests\createUserModel;
use function Tests\expectValidationError;

beforeEach(function () {
    $this->mock(UncompromisedVerifier::class)->shouldReceive('verify')->andReturn(true);
});

it('should reset the user password', function () {
    $user = createUserModel();

    expect($user->password)->toBe('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

    resolve(UpdateUserPassword::class)->update($user, [
        'current_password'      => 'password',
        'password'              => 'Pas3w05d&123456',
        'password_confirmation' => 'Pas3w05d&123456',
    ]);

    expect($user->password)->not()->toBe('$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');
});

it('should throw an exception if the old password is missing', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserPassword::class)->update($user, [
        'current_password'      => null,
        'password'              => 'Pas3w05d&123456',
        'password_confirmation' => 'Pas3w05d&123456',
    ]), 'current_password', 'The current password field is required.');
});

it('should throw an exception if the new password is too short', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserPassword::class)->update($user, [
        'current_password'      => 'password',
        'password'              => 'Pas3w05d&',
        'password_confirmation' => 'Pas3w05d&',
    ]), 'password', 'The password must be at least 12 characters.');
});

it('should throw an exception if the new password is too weak', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserPassword::class)->update($user, [
        'current_password' => 'password',
        'password'         => 'weak',
    ]), 'password', 'The password must be at least 12 characters.');
});

it('should throw an exception if the new password is not confirmed', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserPassword::class)->update($user, [
        'current_password' => 'password',
        'password'         => 'Pas3w05d&123456',
    ]), 'password', 'The password confirmation does not match.');
});

it('should throw an exception if the new password confirmation does not match', function () {
    $user = createUserModel();

    expectValidationError(fn () => resolve(UpdateUserPassword::class)->update($user, [
        'current_password'      => 'password',
        'password'              => 'Pas3w05d&123456',
        'password_confirmation' => 'password',
    ]), 'password', 'The password confirmation does not match.');
});
