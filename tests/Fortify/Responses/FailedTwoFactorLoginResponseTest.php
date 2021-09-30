<?php

declare(strict_types=1);

namespace Tests\Models\Concerns;

use ARKEcosystem\Foundation\Fortify\Responses\FailedTwoFactorLoginResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Mockery;

it('refuses to return json', function () {
    $request = Mockery::mock(\Illuminate\Http\Request::class);
    $request->shouldReceive('only')
        ->once()
        ->andReturn(['key' => 'value']);
    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnTrue();

    (new FailedTwoFactorLoginResponse())->toResponse($request);
})->throws(ValidationException::class, 'The given data was invalid.');

it('can return redirect back', function () {
    $session = Mockery::mock(\Illuminate\Session\Store::class);
    $session->shouldReceive('get')
        ->once()
        ->with('login.idFailure')
        ->andReturn('whatever');
    $session->shouldReceive('put')
        ->once()
        ->with([
            'login.id' => 'whatever',
        ]);

    $request = Mockery::mock(\Illuminate\Http\Request::class);
    $request->shouldReceive('only')
        ->once()
        ->andReturn(['key' => 'value']);
    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnFalse();
    $request->shouldReceive('session')
        ->twice()
        ->andReturn($session);

    $response = (new FailedTwoFactorLoginResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->status())->toBe(302);
});
