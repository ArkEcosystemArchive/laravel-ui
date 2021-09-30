<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components\Concerns;

trait HandleUploadError
{
    use HandleToast;

    public function uploadError(?string $message = null): void
    {
        if (! $message) {
            $message = trans('ui::forms.upload-image.upload_error');
        }

        $this->toast($message, 'error');

        $this->resetErrorBag('temporaryImages');
    }
}
