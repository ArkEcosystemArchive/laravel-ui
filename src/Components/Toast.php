<?php

namespace ARKEcosystem\UserInterface\Components;

use Illuminate\Support\Arr;
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
            'style'    => $this->getValidStyle(Arr::get($message, 2, 'regular')),
        ];
    }

    private function getValidStyle(string $style): string
    {
        return Arr::get([
            // Without close button and icon
            'simple' => 'simple',
            // Only icon, no close button
            'onlyicon' => 'onlyicon',
            // With close button and icon
            'regular' => 'regular',
        ], $style, 'regular');
    }

    public function dismissToast(string $id): void
    {
        unset($this->toasts[$id]);
    }
}
