<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Components\UpdateProfileInformationForm;
use Livewire\Livewire;
use function Tests\createUserModel;

it('can interact with the form', function () {
    $user = createUserModel();

    Livewire::actingAs($user)
        ->test(UpdateProfileInformationForm::class)
        ->assertSet('state', $user->toArray())
        ->call('updateProfileInformation')
        ->assertEmitted('saved')
        ->assertEmitted('refresh-navigation-dropdown');
});
