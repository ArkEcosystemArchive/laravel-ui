<?php

use ARKEcosystem\UserInterface\Components\Toast;
use Livewire\Livewire;

it('can_see_a_toast', function () {
    Livewire::test(Toast::class)
        ->emit('toastMessage', ['Hello', 'info'])
        ->assertSee('Hello')
        ->assertSee('info');
});

it('can_dismiss_a_toast', function () {
    Livewire::test(Toast::class)
        ->set('toasts', ['test123' => [
            'message' => 'Hello',
            'type'    => 'info',
        ]])
        ->assertSee('Hello')
        ->assertSee('info')
        ->call('dismissToast', 'test123')
        ->assertDontSee('Hello');
});
