<?php

declare(strict_types=1);

namespace Tests\Models\Concerns;

use ARKEcosystem\Foundation\Fortify\Responses\TwoFactorLoginResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Mockery;

it('can return json', function () {
    $request = Mockery::mock(\Illuminate\Http\Request::class);
    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnTrue();

    $response = (new TwoFactorLoginResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(JsonResponse::class);
    expect($response->getData())->toBe('');
});

it('can return redirect to intended url', function () {
    $session = Mockery::mock(\Illuminate\Session\Store::class);
    $session->shouldReceive('has')
        ->once()
        ->with('url.intended')
        ->andReturnTrue();
    $session->shouldReceive('pull')
        ->once()
        ->with('url.intended')
        ->andReturn('somewhere');

    $request = Mockery::mock(\Illuminate\Http\Request::class);
    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnFalse();
    $request->shouldReceive('session')
        ->twice()
        ->andReturn($session);

    $response = (new TwoFactorLoginResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->status())->toBe(302);
    expect($response->content())->toContain('somewhere');
});

it('can return redirect home', function () {
    $session = Mockery::mock(\Illuminate\Session\Store::class);
    $session->shouldReceive('has')
        ->once()
        ->with('url.intended')
        ->andReturnFalse();

    $request = Mockery::mock(\Illuminate\Http\Request::class);
    $request->shouldReceive('wantsJson')
        ->once()
        ->andReturnFalse();
    $request->shouldReceive('session')
        ->once()
        ->andReturn($session);

    $response = (new TwoFactorLoginResponse())->toResponse($request);

    expect($response)->toBeInstanceOf(RedirectResponse::class);
    expect($response->status())->toBe(302);
    expect($response->content())->toContain(config('fortify.home'));
});
