<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use Livewire\Component;
use Livewire\WithFileUploads;

abstract class UploadImage extends Component
{
    use WithFileUploads;

    public $alignment;

    public $photo;

    public $dimensions;

    public $readonly = false;

    abstract public function render();

    abstract public function store();

    abstract public function delete();

    public function updatedPhoto()
    {
        $this->store();
    }

    public function validators()
    {
        return ['mimes:jpeg,png,bmp,jpg', 'max:2048'];
    }
}
