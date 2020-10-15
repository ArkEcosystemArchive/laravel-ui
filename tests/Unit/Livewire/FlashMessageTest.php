<?php

use ARKEcosystem\UserInterface\Components\FlashMessage;
use Livewire\Livewire;

it('can_see_flash_message', function () {
    Livewire::test(FlashMessage::class)
        ->emit('flashMessage', ['Hello', 'info'])
        ->assertSee('Hello')
        ->assertSee('info');
});
