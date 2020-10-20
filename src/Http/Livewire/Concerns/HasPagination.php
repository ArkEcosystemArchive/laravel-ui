<?php

namespace ARKEcosystem\UserInterface\Http\Livewire\Concerns;

use Livewire\WithPagination;

trait HasPagination
{
    use WithPagination;

    public function gotoPage(int $page): void
    {
        $this->emit('pageChanged');
        $this->page = $page;
    }
}
