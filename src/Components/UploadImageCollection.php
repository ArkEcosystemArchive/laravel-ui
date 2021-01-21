<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

abstract class UploadImageCollection extends Component
{
    use WithFileUploads;

    public Collection $imageCollection;

    public $temporaryImage;

    abstract public function saveImageCollection();

    public function updatedTemporaryImage()
    {
        $this->validate($this->validators());

        $this->imageCollection->add([
            'photo' => $this->temporaryImage,
            'path'  => '/'.$this->temporaryImage->storePubliclyAs('public', $this->temporaryImage->hashName(), 'public'),
        ]);
    }

    public function deleteImage(int $index): void
    {
        $this->imageCollection->forget($index);
    }

    public function validators()
    {
        return [
            'imageCollection' => ['max:8'],
            'temporaryImage'  => ['mimes:jpeg,png,bmp,jpg', 'max:2048'],
        ];
    }
}
