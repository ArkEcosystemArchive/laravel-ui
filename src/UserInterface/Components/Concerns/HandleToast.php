<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components\Concerns;

trait HandleToast
{
    public function toast(string $message, string $type = 'success'): void
    {
        $this->emit('toastMessage', [$message, $type]);
    }
}
