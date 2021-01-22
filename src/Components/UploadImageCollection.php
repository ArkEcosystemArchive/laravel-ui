<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use Illuminate\Support\Collection;
use Livewire\WithFileUploads;

trait UploadImageCollection
{
    use WithFileUploads;

    public array $imageCollection = [];

    public $temporaryImage;

    public function updatedTemporaryImage()
    {
        $this->validate($this->imageCollectionValidators());

        $this->imageCollection[] = [
            'image' => $this->temporaryImage,
            'url'   => $this->temporaryImage->temporaryUrl(),
        ];
    }

    public function deleteImage(int $index): void
    {
        $this->imageCollection = collect($this->imageCollection)->forget($index)->toArray();
    }

    public function imageCollectionValidators(): array
    {
        return [
            'imageCollection' => ['array', 'max:7'], // max 8 entries as we validate before adding to array
            'temporaryImage'  => ['mimes:jpeg,png,bmp,jpg', 'max:2048'],
        ];
    }
}
