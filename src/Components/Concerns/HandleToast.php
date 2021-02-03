<?php

namespace ARKEcosystem\UserInterface\Components\Concerns;

trait HandleToast
{
    public function toast(string $message, string $type = 'success'): void
    {
        $this->emit('toastMessage', [$message, $type]);
    }
}
