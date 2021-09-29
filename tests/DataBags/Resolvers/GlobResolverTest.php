<?php

use ARKEcosystem\UserInterface\DataBags\DataBag;
use ARKEcosystem\UserInterface\DataBags\Resolvers\GlobResolver;
use Illuminate\Support\Facades\Route;

it('should match by a glob pattern', function () {
    expect((new GlobResolver())->resolve([
        'meta' => [
            '/*' => [
                'title' => 'Any',
            ],
        ],
    ], 'meta'))->toBe(['title' => 'Any']);
});

it('should match by a glob pattern through a request', function () {
    DataBag::register('meta', [
        'posts/*' => [
            'title' => 'Hello World',
        ],
        '*' => [
            'title' => 'Any',
        ],
    ]);

    Route::get('/', fn () => DataBag::resolveByGlob('meta'));
    Route::get('/posts', fn () => DataBag::resolveByGlob('meta'));
    Route::get('/posts/hello-world', fn () => DataBag::resolveByGlob('meta'));

    expect($this->call('GET', '/')->json())->toBe(['title' => 'Any']);
    expect($this->call('GET', '/posts')->json())->toBe(['title' => 'Any']);
    expect($this->call('GET', '/posts/hello-world')->json())->toBe(['title' => 'Hello World']);
});
