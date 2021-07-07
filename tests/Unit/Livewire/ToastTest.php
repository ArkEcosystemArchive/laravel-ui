<?php

use ARKEcosystem\UserInterface\Components\Toast;
use Livewire\Livewire;

it('can_see_a_toast', function () {
    Livewire::test(Toast::class)
        ->emit('toastMessage', ['Hello', 'info'])
        ->assertSee('Hello')
        ->assertSee('button')
        ->assertSee('span');
});

it('hides the button if style is `onlyicon`', function () {
    Livewire::test(Toast::class)
        ->emit('toastMessage', ['Hello', 'info', 'onlyicon'])
        ->assertSee('Hello')
        ->assertDontSee('button')
        ->assertSee('span');
});

it('hides the button and the icon if style is `simple`', function () {
    Livewire::test(Toast::class)
        ->emit('toastMessage', ['Hello', 'info', 'simple'])
        ->assertSee('Hello')
        ->assertDontSee('button')
        ->assertDontSee('span');
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
