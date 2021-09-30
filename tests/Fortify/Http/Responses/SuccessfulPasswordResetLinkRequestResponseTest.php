<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Http\Responses\SuccessfulPasswordResetLinkRequestResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

it('The success response flash a message', function () {
    $response = new SuccessfulPasswordResetLinkRequestResponse(Password::RESET_LINK_SENT);
    $response = $response->toResponse(new Request());

    expect($response->getStatusCode())->toBe(302);

    expect(app('session.store')->get('laravel_flash_message'))->toHaveKey('message');
});

it('the success json response', function () {
    $request = Mockery::mock(Request::class);
    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnTrue();

    $response = new SuccessfulPasswordResetLinkRequestResponse(Password::RESET_LINK_SENT);
    $response = $response->toResponse($request);

    expect($response->getStatusCode())->toBe(200);
    expect($response->getData('message'))->toBe(['message' => 'We have emailed your password reset link!']);
});
