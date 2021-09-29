<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\UserInterface\Components\UploadImageSingle;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;

class UpdateProfilePhotoForm extends Component
{
    use InteractsWithUser;
    use UploadImageSingle;

    public string $dimensions = '';

    public string $alignment = '';

    public string $formClass = '';

    public bool $withCrop = false;

    public string $cropOptions = '{}';

    public function mount(string $dimensions = 'w-48 h-48', string $alignment = 'items-center mb-4 md:items-start', string $formClass = '', bool $withCrop = false, string $cropOptions = '{}')
    {
        $this->dimensions  = $dimensions;
        $this->alignment   = $alignment;
        $this->formClass   = $formClass;
        $this->withCrop    = $withCrop;
        $this->cropOptions = $cropOptions;
    }

    public function render(): View
    {
        return view('ark-fortify::profile.update-profile-photo-form');
    }

    public function updatedImageSingle(): void
    {
        if (! is_a($this->imageSingle, TemporaryUploadedFile::class)) {
            $this->imageSingle = TemporaryUploadedFile::createFromLivewire($this->imageSingle);
        }

        $this->validateImageSingle();

        $this->user
            ->addMedia($this->imageSingle->getRealPath())
            ->withResponsiveImages()
            ->usingName($this->imageSingle->hashName())
            ->toMediaCollection('photo');

        $this->user->refresh();
    }

    public function deleteImageSingle(): void
    {
        $this->user->getFirstMedia('photo')->delete();
        $this->user->refresh();

        if (is_a($this->imageSingle, TemporaryUploadedFile::class)) {
            $this->imageSingle->delete();
        }

        $this->imageSingle = null;
    }
}
