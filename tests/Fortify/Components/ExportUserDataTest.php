<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Components\ExportUserData;
use Livewire\Livewire;
use Spatie\PersonalDataExport\Jobs\CreatePersonalDataExportJob;
use function Tests\createUserModel;

it('can export the user data', function () {
    $this->expectsJobs(CreatePersonalDataExportJob::class);

    Livewire::actingAs(createUserModel())
        ->test(ExportUserData::class)
        ->call('export')
        ->assertEmitted('toastMessage', [trans('fortify::pages.user-settings.data_exported'), 'success']);
});

it('can only export the user data once every 15 min', function () {
    $this->expectsJobs(CreatePersonalDataExportJob::class);

    $component = Livewire::actingAs(createUserModel())
        ->test(ExportUserData::class)
        ->call('export')
        ->assertEmitted('toastMessage', [trans('fortify::pages.user-settings.data_exported'), 'success'])
        ->call('export')
        ->assertNotEmitted('toastMessage', [trans('fortify::pages.user-settings.data_exported'), 'success']);

    $this->travel(16)->minutes();

    $component->call('export')
        ->assertEmitted('toastMessage', [trans('fortify::pages.user-settings.data_exported'), 'success']);
});
