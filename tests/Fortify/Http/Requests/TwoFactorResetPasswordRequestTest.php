<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Http\Requests\TwoFactorResetPasswordRequest;
use ARKEcosystem\Foundation\Fortify\Models\User;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Exceptions\HttpResponseException;
use Laravel\Fortify\Contracts\FailedTwoFactorLoginResponse;
use function Tests\createUserModel;

it('validates the request token', function () {
    $user = createUserModel();
    $token = 'abcd';

    $this->mock(PasswordBroker::class)
        ->shouldReceive('tokenExists')
        ->with($user, $token)
        ->andReturn(true);

    $this->partialMock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('route')
        ->with('token')
        ->andReturn($token)
        ->shouldReceive('challengedUser')
        ->andReturn($user);

    $request = app(TwoFactorResetPasswordRequest::class);

    expect($request->hasValidToken())->toBeTrue();

    $this->mock(PasswordBroker::class)
        ->shouldReceive('tokenExists')
        ->with($user, $token)
        ->andReturn(false);

    $request = app(TwoFactorResetPasswordRequest::class);

    expect($request->hasValidToken())->toBeFalse();
});

it('validates the user', function () {
    $user = createUserModel();

    $this->partialMock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('get')
        ->with('email')
        ->andReturn($user->email)
        ->shouldReceive('has')
        ->with('email')
        ->andReturn(true);

    $this->mock(UserProvider::class)
        ->shouldReceive('getModel')
        ->andReturn(User::class);

    $this->mock(StatefulGuard::class)
        ->shouldReceive('getProvider')
        ->andReturn(app(UserProvider::class));

    $request = app(TwoFactorResetPasswordRequest::class);

    expect($request->hasChallengedUser())->toBeTrue();
});

it('validates not existing user', function () {
    createUserModel();

    $this->partialMock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('get')
        ->with('email')
        ->andReturn('other@example.com')
        ->shouldReceive('has')
        ->with('email')
        ->andReturn(true);

    $this->mock(UserProvider::class)
        ->shouldReceive('getModel')
        ->andReturn(User::class);

    $this->mock(StatefulGuard::class)
        ->shouldReceive('getProvider')
        ->andReturn(app(UserProvider::class));

    $request = app(TwoFactorResetPasswordRequest::class);

    expect($request->hasChallengedUser())->toBeFalse();
});

it('gets the challenged user', function () {
    $user = createUserModel();

    $this->partialMock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('get')
        ->with('email')
        ->andReturn($user->email)
        ->shouldReceive('has')
        ->with('email')
        ->andReturn(true);

    $this->mock(UserProvider::class)
        ->shouldReceive('getModel')
        ->andReturn(User::class);

    $this->mock(StatefulGuard::class)
        ->shouldReceive('getProvider')
        ->andReturn(app(UserProvider::class));

    $request = app(TwoFactorResetPasswordRequest::class);

    expect($request->challengedUser()->is($user))->toBeTrue();

    // A second time, now it comes from the protected property
    expect($request->challengedUser()->is($user))->toBeTrue();
});

it('throws an exception if email not found', function () {
    $this->expectException(HttpResponseException::class);

    createUserModel();

    $this->partialMock(TwoFactorResetPasswordRequest::class)
        ->shouldReceive('get')
        ->with('email')
        ->andReturn('other@example.com')
        ->shouldReceive('has')
        ->with('email')
        ->andReturn(true)
        ->shouldReceive('only')
        ->andReturn([])
        ->shouldReceive('wantsJson')
        ->andReturn(false);

    $this->mock(UserProvider::class)
        ->shouldReceive('getModel')
        ->andReturn(User::class);

    $this->mock(StatefulGuard::class)
        ->shouldReceive('getProvider')
        ->andReturn(app(UserProvider::class));

    $this->mock(FailedTwoFactorLoginResponse::class)
        ->shouldReceive('toResponse')
        ->andReturn(new \Symfony\Component\HttpFoundation\Response());

    $request = app(TwoFactorResetPasswordRequest::class);

    $request->challengedUser();
});
