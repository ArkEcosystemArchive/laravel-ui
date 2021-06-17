<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use ARKEcosystem\UserInterface\Components\Concerns\HandleUploadError;
use Illuminate\Support\Facades\Validator;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

trait UploadImageCollection
{
    use HandleUploadError;
    use WithFileUploads;

    public array $imageCollection = [];

    public $temporaryImages = [];

    public function getImageCollectionMaxQuantity(): int
    {
        return 8;
    }

    public function updatedTemporaryImages()
    {
        $this->temporaryImages = collect($this->temporaryImages)->map(function ($image) {
            if ($image instanceof TemporaryUploadedFile) {
                return $image;
            }

            return TemporaryUploadedFile::createFromLivewire($image);
        })->toArray();

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
            'imageCollection' => ['array', 'max:' . $this->getImageCollectionMaxQuantity()],
            'temporaryImages'  => function ($attribute, $value, $fail) {
                $max = $this->getImageCollectionMaxQuantity();

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
                'dimensions:min_width=148,min_height=148',
            ],
        ];
    }

    public function updateImageOrder(array $order): void
    {
        if (! method_exists($this, 'imagesReordered')) {
            return;
        }

        $this->imageCollection = collect($order)->map(function ($item) {
            return collect($this->imageCollection)->get($item['value']);
        })->toArray();

        $orderedIds = collect($this->imageCollection)->map(fn ($item) => data_get($item, 'image.id'))->filter()->toArray();

        if ($orderedIds !== []) {
            $this->imagesReordered($orderedIds);
        }
    }
}
