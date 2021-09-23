<?php

declare(strict_types=1);

use ARKEcosystem\UserInterface\Http\Middlewares\DropInvalidLivewireRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Livewire\Exceptions\ComponentNotFoundException;
use Livewire\LivewireManager;
use Symfony\Component\HttpKernel\Exception\HttpException;

function mockRequest(string $routeName = 'testing::dummy', array $payload = []) : Request {
    $route = Route::get('/dummy', fn () => response('OK'))->name($routeName);

    return tap(new Request)
            ->setRouteResolver(fn () => $route)
            ->merge($payload);
}

it('ignores all non-livewire requests', function () {
    $request = mockRequest();

    expect($request->routeIs('testing::dummy'))->toBeTrue();

    $called = false;

    $response = (new DropInvalidLivewireRequests)->handle($request, function () use (&$called) {
        $called = true;

        return 'Hello world';
    });

    expect($response)->toBe('Hello world');
    expect($called)->toBeTrue();
});

it('drops if component is not found', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id' => 'dummy-id',
            'name' => 'dummy-name',
            'method' => 'POST',
            'path' => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    $this->mock(LivewireManager::class, function ($mock) {
        $mock->shouldReceive('getClass')->with('dummy-name')->andThrow(ComponentNotFoundException::class);
    });

    try {
        $response = (new DropInvalidLivewireRequests)->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if fingerprint ID is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id' => '',
            'name' => 'dummy-name',
            'method' => 'POST',
            'path' => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    $this->mock(LivewireManager::class, function ($mock) {
        $mock->shouldReceive('getClass')->with('dummy-name')->andReturn('done');
    });

    try {
        $response = (new DropInvalidLivewireRequests)->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if fingerprint component name is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id' => 'dummy-id',
            'name' => '',
            'method' => 'POST',
            'path' => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    $this->mock(LivewireManager::class, function ($mock) {
        $mock->shouldReceive('getClass')->with('dummy-name')->andReturn('done');
    });

    try {
        $response = (new DropInvalidLivewireRequests)->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if fingerprint method is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id' => 'dummy-id',
            'name' => 'dummy-name',
            'method' => '',
            'path' => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    $this->mock(LivewireManager::class, function ($mock) {
        $mock->shouldReceive('getClass')->with('dummy-name')->andReturn('done');
    });

    try {
        $response = (new DropInvalidLivewireRequests)->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if fingerprint path is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id' => 'dummy-id',
            'name' => 'dummy-name',
            'method' => 'POST',
            'path' => '',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => 'some-hash',
        ],
    ]);

    $this->mock(LivewireManager::class, function ($mock) {
        $mock->shouldReceive('getClass')->with('dummy-name')->andReturn('done');
    });

    try {
        $response = (new DropInvalidLivewireRequests)->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if checksum is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id' => 'dummy-id',
            'name' => 'dummy-name',
            'method' => 'POST',
            'path' => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => '',
            'htmlHash' => 'some-hash',
        ],
    ]);

    $this->mock(LivewireManager::class, function ($mock) {
        $mock->shouldReceive('getClass')->with('dummy-name')->andReturn('done');
    });

    try {
        $response = (new DropInvalidLivewireRequests)->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if html hash is missing', function () {
    $request = mockRequest('livewire.message', [
        'fingerprint' => [
            'id' => 'dummy-id',
            'name' => 'dummy-name',
            'method' => 'POST',
            'path' => '/dummy',
        ],
        'serverMemo' => [
            'checksum' => 'some-checksum',
            'htmlHash' => '',
        ],
    ]);

    $this->mock(LivewireManager::class, function ($mock) {
        $mock->shouldReceive('getClass')->with('dummy-name')->andReturn('done');
    });

    try {
        $response = (new DropInvalidLivewireRequests)->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});

it('drops if payload is missing', function () {
    $request = mockRequest('livewire.message', [
        //
    ]);

    try {
        $response = (new DropInvalidLivewireRequests)->handle($request, fn () => 'Hello world');

        $this->fail('HTTPException was not thrown.');
    } catch (HttpException $e) {
        // 404 was thrown...
        expect(true)->toBeTrue();
    }
});
