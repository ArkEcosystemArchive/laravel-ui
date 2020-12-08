<?php

namespace ARKEcosystem\UserInterface\Http\Livewire\Concerns;

trait HasModal
{
    public bool $modalShown = false;

    public function closeModal(): void
    {
        $this->modalShown = false;

        $this->modalClosed();
    }

    public function openModal(): void
    {
        $this->modalShown = true;
    }

    public function modalClosed(): void
    {
        $this->emit('modalClosed', $this->modalId);
    }
}
