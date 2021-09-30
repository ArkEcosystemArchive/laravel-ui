<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\Fortify\Components\Concerns\InteractsWithUser;
use ARKEcosystem\Foundation\Fortify\Components\Concerns\ValidatesPassword;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Livewire\Component;

class UpdatePasswordForm extends Component
{
    use InteractsWithUser;
    use ValidatesPassword;

    protected $listeners = ['passwordUpdated' => 'passwordUpdated'];

    public string $currentPassword = '';

    public ?string $password = '';

    public ?string $password_confirmation = '';

    /**
     * Update the user's password.
     *
     * @param \Laravel\Fortify\Contracts\UpdatesUserPasswords $updater
     *
     * @return void
     */
    public function updatePassword(UpdatesUserPasswords $updater)
    {
        $this->resetErrorBag();

        $updater->update(Auth::user(), [
            'current_password'      => $this->currentPassword,
            'password'              => $this->password,
            'password_confirmation' => $this->password_confirmation,
        ]);

        $this->currentPassword       = '';
        $this->password              = '';
        $this->password_confirmation = '';

        $this->dispatchBrowserEvent('updated-password');
        $this->resetRules();

        $this->emit('toastMessage', [trans('fortify::pages.user-settings.password_updated'), 'success']);
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::profile.update-password-form');
    }
}
