<?php

use Illuminate\Support\Facades\Route;

it('should render the component', function (): void {
    Route::view('/', 'ark::navbar.logo')->name('home');

    $this
        ->assertView('ark::navbar.logo', [
            'title' => 'Explorer',
        ])
        ->contains('<div class="hidden ml-6 text-lg lg:block"><span class="font-black text-theme-secondary-900">ARK</span> Explorer</div>');
});

it('should render the [logo] slot', function (): void {
    Route::view('/', 'ark::navbar.logo')->name('home');

    $this
        ->assertView('ark::navbar.logo', [
            'logo' => 'custom-logo',
        ])
        ->contains('custom-logo');
});
