<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use Illuminate\Support\Facades\Validator;
use Livewire\WithFileUploads;
use ARKEcosystem\UserInterface\Components\Concerns\HandleUploadError;

trait UploadImageSingle
{
    use HandleUploadError;
    use WithFileUploads;

    public $imageSingle;

    public $readonly = false;

    abstract public function render();

    abstract public function updatedImageSingle();

    abstract public function deleteImageSingle();

    public function validateImageSingle(): void
    {
        $validator = Validator::make([
            'imageSingle' => $this->imageSingle,
        ], $this->imageSingleValidators());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->uploadError($error);
            }

            $validator->validate();
        }
    }

    public function imageSingleValidators(): array
    {
        return [
            'imageSingle' => ['mimes:jpeg,png,bmp,jpg', 'max:2048', 'dimensions:min_width=148,min_height=148'],
        ];
    }
}
