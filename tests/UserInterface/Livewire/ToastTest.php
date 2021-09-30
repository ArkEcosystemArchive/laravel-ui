<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\UserInterface\Components\Toast;
use Livewire\Livewire;

it('can_see_a_toast', function () {
    Livewire::test(Toast::class)
        ->emit('toastMessage', ['Hello', 'info'])
        ->assertSee('Hello') // body
        ->assertSee('button') // close button
        ->assertSee('span'); // icon
});

it('can_dismiss_a_toast', function () {
    Livewire::test(Toast::class)
        ->set('toasts', ['test123' => [
            'message' => 'Hello',
            'type'    => 'info',
            'style'   => 'regular',
        ]])
        ->assertSee('Hello')
        ->assertSee('button')
        ->assertSee('span')
        ->call('dismissToast', 'test123')
        ->assertDontSee('button')
        ->assertDontSee('span');
});
