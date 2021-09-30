<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Http\Controllers\TwoFactorAuthenticatedPasswordResetController;
use ARKEcosystem\Foundation\Fortify\Http\Requests\TwoFactorResetPasswordRequest;
use ARKEcosystem\Foundation\Fortify\Responses\FailedTwoFactorLoginResponse;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\View\View;
use function Tests\createUserModel;

it('shows the two auth challenge form', function () {
    $user = createUserModel();

    $this->mock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('hasChallengedUser')
        ->andReturn(true)
        ->shouldReceive('hasValidToken')
        ->andReturn(true)
        ->shouldReceive('challengedUser')
        ->andReturn($user);

    $request = app(TwoFactorResetPasswordRequest::class);

    $controller = app(TwoFactorAuthenticatedPasswordResetController::class);

    $token = 'abcd';

    $response = $controller->create($request, $token);
    expect($response)->toBeInstanceOf(View::class);
    expect($response->getName())->toBe('ark-fortify::auth.two-factor-challenge');
    expect($response->getData())->toEqual([
        'token'         => $token,
        'resetPassword' => true,
        'email'         => $user->email,
    ]);
});

it('throws an http exception if the token is invalid', function () {
    $this->expectException(HttpResponseException::class);

    createUserModel();

    $this->mock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('hasChallengedUser')
        ->andReturn(true)
        ->shouldReceive('hasValidToken')
        ->andReturn(false);

    $request = app(TwoFactorResetPasswordRequest::class);

    $controller = app(TwoFactorAuthenticatedPasswordResetController::class);

    $token = 'abcd';

    $controller->create($request, $token);
});

it('throws an http exception if is not able to get the user', function () {
    $this->expectException(HttpResponseException::class);

    createUserModel();

    $request = $this->mock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('hasChallengedUser')
        ->andReturn(false);

    $request = app(TwoFactorResetPasswordRequest::class);

    $controller = app(TwoFactorAuthenticatedPasswordResetController::class);

    $token = 'abcd';

    $controller->create($request, $token);
});

it('shows the reset form after validating the token', function () {
    $user = createUserModel();

    $user->two_factor_recovery_codes = encrypt('wharever');
    $user->save();

    $this->mock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('hasChallengedUser')
        ->andReturn(true)
        ->shouldReceive('hasValidToken')
        ->andReturn(true)
        ->shouldReceive('challengedUser')
        ->andReturn($user)
        ->shouldReceive('validRecoveryCode')
        ->andReturn(encrypt('the_code'));

    $request = app(TwoFactorResetPasswordRequest::class);

    $controller = app(TwoFactorAuthenticatedPasswordResetController::class);

    $token = 'abcd';

    $response = $controller->store($request, $token);
    expect($response)->toBeInstanceOf(View::class);
    expect($response->getName())->toBe('ark-fortify::auth.reset-password');
});

it('throws an http exception if the token is invalid when validating 2fa', function () {
    $this->expectException(HttpResponseException::class);

    $user = createUserModel();

    $this->mock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('challengedUser')
        ->andReturn($user)
        ->shouldReceive('hasChallengedUser')
        ->andReturn(true)
        ->shouldReceive('hasValidToken')
        ->andReturn(false);

    $request = app(TwoFactorResetPasswordRequest::class);

    $controller = app(TwoFactorAuthenticatedPasswordResetController::class);

    $token = 'abcd';

    $controller->store($request, $token);
});

it('returns a failed two factor login response if the code is invalid', function () {
    $user = createUserModel();

    $this->mock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('challengedUser')
        ->andReturn($user)
        ->shouldReceive('hasChallengedUser')
        ->andReturn(true)
        ->shouldReceive('hasValidToken')
        ->andReturn(true)
        ->shouldReceive('validRecoveryCode')
        ->andReturn(false)
        ->shouldReceive('hasValidCode')
        ->andReturn(false);

    $request = app(TwoFactorResetPasswordRequest::class);

    $controller = app(TwoFactorAuthenticatedPasswordResetController::class);

    $token = 'abcd';

    $response = $controller->store($request, $token);
    expect($response)->toBeInstanceOf(FailedTwoFactorLoginResponse::class);
});
