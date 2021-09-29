<?php

namespace ARKEcosystem\UserInterface\Components\Concerns;

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
