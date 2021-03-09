<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use ARKEcosystem\UserInterface\Components\Concerns\HandleUploadError;
use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;

trait UploadImageCollection
{
    use HandleUploadError;
    use WithFileUploads;

    public array $imageCollection = [];

    public $temporaryImages = [];

    public function updatedTemporaryImages()
    {
        $this->validateImageCollection();

        $this->imageCollection = array_merge($this->imageCollection, array_map(fn($image) => [
            'image' => $image,
            'url'   => $image->temporaryUrl(),
        ], $this->temporaryImages));
    }

    public function deleteImage(int $index): void
    {
        $this->imageCollection = collect($this->imageCollection)->forget($index)->toArray();
    }

    public function validateImageCollection(): void
    {
        $validator = Validator::make([
            'imageCollection' => $this->imageCollection,
            'temporaryImages' => $this->temporaryImages,
        ], $this->imageCollectionValidators());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->uploadError($error);
            }

            $validator->validate();
        }
    }

    public function imageCollectionValidators(): array
    {
        return [
            'imageCollection' => ['array', 'max:7'], // max 8 entries as we validate before adding to array
            'temporaryImages.*'  => ['mimes:jpeg,png,bmp,jpg', 'max:2048'],
        ];
    }
}
