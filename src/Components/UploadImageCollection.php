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

    public $temporaryImage;

    public function updatedTemporaryImage()
    {
        $this->validateImageCollection();

        $this->imageCollection[] = [
            'image' => $this->temporaryImage,
            'url'   => $this->temporaryImage->temporaryUrl(),
        ];
    }

    public function deleteImage(int $index): void
    {
        $this->imageCollection = collect($this->imageCollection)->forget($index)->toArray();
    }

    public function validateImageCollection(): void
    {
        $validator = Validator::make([
            'imageCollection' => $this->imageCollection,
            'temporaryImage' => $this->temporaryImage,
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
            'temporaryImage'  => ['mimes:jpeg,png,bmp,jpg', 'max:2048'],
        ];
    }
}
