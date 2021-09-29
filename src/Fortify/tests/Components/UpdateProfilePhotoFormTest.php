<?php

declare(strict_types=1);

use ARKEcosystem\Fortify\Components\UpdateProfilePhotoForm;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Spatie\MediaLibrary\MediaCollections\FileAdderFactory;
use Spatie\MediaLibrary\MediaCollections\MediaRepository;
use Spatie\MediaLibrary\MediaCollections\Models\Collections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tests\MediaUser;

it('can upload a photo', function () {
    $this
        ->mock(FileAdderFactory::class)
        ->shouldReceive('create->withResponsiveImages->usingName->toMediaCollection')
        ->once();

    $photo = UploadedFile::fake()->image('logo.jpeg', 150, 150);

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('imageSingle', $photo);
});

it('can upload a photo from path', function () {
    Storage::fake('tmp-for-tests');

    $this
        ->mock(FileAdderFactory::class)
        ->shouldReceive('create->withResponsiveImages->usingName->toMediaCollection')
        ->once();

    $tempPath = 'vendor/orchestra/testbench-core/laravel/storage/framework/testing/disks/tmp-for-tests/livewire-tmp';
    UploadedFile::fake()->image('logo.jpeg', 150, 150)->move($tempPath, 'logo.jpg');

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('imageSingle', 'logo.jpg');
});

it('cannot upload a photo with invalid extension', function () {
    $photo = UploadedFile::fake()->create('logo.gif', 1000, 'image/gif');

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('imageSingle', $photo)
        ->assertHasErrors('imageSingle');
});

it('cannot upload a photo that is too large', function () {
    $photo = UploadedFile::fake()->image('logo.jpg', 150, 150)->size(10000);

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('imageSingle', $photo)
        ->assertHasErrors('imageSingle');
});

it('can delete a photo', function () {
    $this
        ->mock(FileAdderFactory::class)
        ->shouldReceive('create->withResponsiveImages->usingName->toMediaCollection')
        ->once();

    $media = Mockery::mock(Media::class);
    $media->shouldReceive('delete');

    $collection = Mockery::mock(MediaCollection::class);
    $collection
        ->shouldReceive('collectionName')
        ->andReturnSelf();
    $collection
        ->shouldReceive('first')
        ->andReturn($media);

    $this->mock(MediaRepository::class)
        ->shouldReceive('getCollection')
        ->andReturn($collection);

    $photo = UploadedFile::fake()
        ->image('logo.jpeg', 150, 150)
        ->size(1);

    Livewire::actingAs(MediaUser::fake())
        ->test(UpdateProfilePhotoForm::class)
        ->set('imageSingle', $photo)
        ->call('deleteImageSingle')
        ->assertHasNoErrors('imageSingle');
});
