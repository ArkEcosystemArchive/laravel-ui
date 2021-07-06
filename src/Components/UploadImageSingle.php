<?php

declare(strict_types=1);

namespace ARKEcosystem\UserInterface\Components;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
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
            'imageSingle' => [
                'mimes:'.(string) config('ui.upload.image-single.accept-mime'),
                'max:'.(string) config('ui.upload.image-single.max-filesize'),
                Rule::dimensions()
                    ->minWidth((int) config('ui.upload.image-single.dimensions.min-width'))
                    ->minHeight((int) config('ui.upload.image-single.dimensions.min-height'))
                    ->maxWidth((int) config('ui.upload.image-single.dimensions.max-width'))
                    ->maxHeight((int) config('ui.upload.image-single.dimensions.max-height')),
            ],
        ];
    }
}
