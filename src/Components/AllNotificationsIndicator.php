<?php

namespace ARKEcosystem\UserInterface\Components;

use Livewire\Component;
use Illuminate\View\View;

class AllNotificationsIndicator extends Component
{
    public bool $show = false;
    public bool $checkInvitations = false;
    public bool $checkNotifications = false;

    protected $listeners = [
        'notificationsCountUpdated' => 'updateShowState'
    ];

    public function mount(bool $checkInvitations = false, bool $checkNotifications = false): void
    {
        $this->checkInvitations = $checkInvitations;
        $this->checkNotifications = $checkNotifications;

        $this->updateShowState();
    }

    public function updateShowState(): void
    {
        if (!auth()->check()) {
            $this->show = false;
            return;
        }

        $show = false;

        if ($this->checkInvitations) {
            $show = $show || boolval(auth()->user()->invitations()->count());
        }

        if ($this->checkNotifications) {
            $show = $show || auth()->user()->hasUnreadNotifications();
        }

        $this->show = $show;
    }

    public function render(): View
    {
        return view('ark::livewire.all-notifications-indicator');
    }
}
