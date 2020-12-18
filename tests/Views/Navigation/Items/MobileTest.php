<?php

use Illuminate\Support\Facades\Route;

use function Tests\createAttributes;

it('should render the component with a single item without query parameters', function (): void {
    Route::view('/', 'ark::navbar.items.mobile')->name('home');

    $this
        ->assertView('ark::navbar.items.mobile', createAttributes([
            'navigation' => [
                ['route' => 'home', 'label' => 'Home'],
            ],
        ]))
        ->contains('http://localhost');
});

it('should render the component with a single item with query parameters', function (): void {
    Route::view('/', 'ark::navbar.items.mobile')->name('home');

    $this
        ->assertView('ark::navbar.items.mobile', createAttributes([
            'navigation' => [
                ['route' => 'home', 'label' => 'Home', 'params' => ['hello' => 'world']],
            ],
        ]))
        ->contains('http://localhost?hello=world');
});

it('should render the component with children', function (): void {
    Route::view('/', 'ark::navbar.items.mobile')->name('home');
    Route::view('/post', 'ark::navbar.items.mobile')->name('post');

    $this
        ->assertView('ark::navbar.items.mobile', createAttributes([
            'navigation' => [
                [
                    'route'    => 'home',
                    'label'    => 'Home',
                    'image'    => 'special-icon',
                    'children' => [
                        ['route' => 'post', 'label' => 'Post'],
                    ],
                ],
            ],
        ]))
        ->contains('http://localhost/post');
});
