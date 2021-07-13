<?php

namespace ARKEcosystem\UserInterface\Components;

use Livewire\Component;

class Toast extends Component
{
    public $toasts = [];

    protected $listeners = [
        'toastMessage' => 'handleIncomingMessage',
        'dismissToast' => 'dismissToast',
    ];

    public function render()
    {
        return view('ark::livewire.toast', [
            'toasts' => $this->toasts,
        ]);
    }

    public function handleIncomingMessage(array $message): void
    {
        $this->toasts[uniqid()] = [
            'message' => $message[0],
            'type'    => $message[1],
        ];
    }

    public function dismissToast(string $id): void
    {
        unset($this->toasts[$id]);
    }
}
