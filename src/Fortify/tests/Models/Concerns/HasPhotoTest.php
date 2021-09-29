<?php

declare(strict_types=1);

namespace Tests\Models\Concerns;

use ARKEcosystem\Fortify\Models\Concerns\HasPhoto;
use Mockery;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

/**
 * @coversNothing
 */
class HasPhotoTest implements HasMedia
{
    use HasPhoto;
}

it('can access the photo', function () {
    $media = new Media();
    $subject = $this->getMockForTrait(HasPhoto::class, [], '', true, true, true, ['getFirstMedia']);
    $subject->expects($this->any())
        ->method('getFirstMedia')
        ->will($this->returnValue($media));

    expect($subject->getPhoto())->toBe($media);
});

it('can access the photo url', function () {
    $subject = $this->getMockForTrait(HasPhoto::class, [], '', true, true, true, ['getFirstMediaUrl']);
    $subject->expects($this->any())
        ->method('getFirstMediaUrl')
        ->will($this->returnValue('a url'));

    expect($subject->getPhotoAttribute())->toBe('a url');
});

it('can register media collections', function () {
    $collection = Mockery::mock(MediaCollection::class);
    $collection->shouldReceive('singleFile');

    $subject = $this->getMockForTrait(HasPhoto::class, [], '', true, true, true, ['addMediaCollection']);
    $subject->expects($this->any())
        ->method('addMediaCollection')
        ->will($this->returnValue($collection));

    $subject->registerMediaCollections();
});
