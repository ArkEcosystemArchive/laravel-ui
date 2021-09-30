<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Http\Responses\FailedPasswordResetLinkRequestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

it('if the status is for an invalid user it should return a successful response', function () {
    $response = new FailedPasswordResetLinkRequestResponse(Password::INVALID_USER);
    $response = $response->toResponse(new Request());

    expect($response->getStatusCode())->toBe(302);

    expect(app('session.store')->get('errors'))->toBe(null);

    expect(app('session.store')->get('laravel_flash_message'))->toHaveKey('message');
});

it('if the status is for another kind of error return the error response', function () {
    $response = new FailedPasswordResetLinkRequestResponse(Password::INVALID_TOKEN);
    $response = $response->toResponse(new Request());

    expect($response->getStatusCode())->toBe(302);
    expect(app('session.store')->get('errors')->has('email'))->toBe(true);
});
