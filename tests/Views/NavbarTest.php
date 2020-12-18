<?php

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Route;

use function Tests\createAttributes;

it('should render the component', function (): void {
    Route::view('/', 'ark::navbar.hamburger')->name('home');
    Route::view('/post', 'ark::navbar.hamburger')->name('post');

    $this
        ->actingAs(new User())
        ->assertView('ark::navbar', createAttributes([
            'title'      => 'Explorer',
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
            'profilePhoto'     => 'https://imgur.com/abc123',
            'profileMenu'      => [],
            'profileMenuClass' => 'unicorn',
        ]))
        ->contains('http://localhost/post')
        ->contains('special-icon')
        ->contains('src="https://imgur.com/abc123"')
        ->contains('unicorn');
});
