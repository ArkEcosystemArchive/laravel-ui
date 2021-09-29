<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Models\Concerns;

use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

trait HasPhoto
{
    use InteractsWithMedia;

    public function getPhoto(): ?Media
    {
        return $this->getFirstMedia('photo');
    }

    public function getPhotoAttribute(): string
    {
        return $this->getFirstMediaUrl('photo');
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('photo')->singleFile();
    }
}
