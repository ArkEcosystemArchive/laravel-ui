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

    public function getImageCollectionMaxQuantity(): int
    {
        return 0;
    }

    public function updatedTemporaryImages()
    {
        if (!$this->validateImageCollection()) {
            return;
        }

        $this->imageCollection = array_merge($this->imageCollection, array_map(fn($image) => [
            'image' => $image,
            'url'   => $image->temporaryUrl(),
        ], $this->temporaryImages));
    }

    public function deleteImage(int $index): void
    {
        $this->imageCollection = collect($this->imageCollection)->forget($index)->toArray();
    }

    public function validateImageCollection(): bool
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

            return false;
        }

        return true;
    }

    public function imageCollectionValidators(): array
    {
        return [
            'imageCollection' => ['array', $this->getImageCollectionMaxQuantity() > 0 ? ('max:' . $this->getImageCollectionMaxQuantity()) : ''], // max 8 entries as we validate before adding to array
            'temporaryImages'  => function ($attribute, $value, $fail) {
                $max = $this->getImageCollectionMaxQuantity();

                if ($max <= 0) {
                    return;
                }

                if (count($value) + count($this->imageCollection) > $max) {
                    $fail(trans('validation.max.array', [
                        'max' => $max,
                        'attribute' => 'image collection',
                    ]));
                }
            },
            'temporaryImages.*'  => [
                'mimes:jpeg,png,bmp,jpg',
                'max:2048',
            ],
        ];
    }
}
