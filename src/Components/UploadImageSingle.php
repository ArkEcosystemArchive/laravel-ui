<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use Livewire\WithFileUploads;

trait UploadImageSingle
{
    use WithFileUploads;

    public $imageSingle;

    public $readonly = false;

    public array $imageSingleValidators = ['mimes:jpeg,png,bmp,jpg', 'max:2048'];

    abstract public function render();

    abstract public function updatedImageSingle();

    abstract public function deleteImageSingle();
}
