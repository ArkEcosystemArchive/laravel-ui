<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Http\Livewire\Concerns;

use Livewire\WithPagination;

trait HasPagination
{
    use WithPagination;

    public function gotoPage(int $page): void
    {
        $this->emit('pageChanged');
        $this->setPage($page);
    }
}
