<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\Fortify\Components\Concerns\ValidatesPassword;
use ARKEcosystem\Foundation\Fortify\Models;
use Livewire\Component;

class RegisterForm extends Component
{
    use ValidatesPassword;

    public ?string $name = '';

    public ?string $username = '';

    public ?string $email = '';

    public ?string $password = '';

    public ?string $password_confirmation = '';

    public bool $terms = false;

    public string $formUrl;

    public ?string $invitationId = null;

    public function mount()
    {
        $this->name     = old('name', '');
        $this->username = old('username', '');
        $this->email    = old('email', '');
        $this->terms    = old('terms', false) === true;

        $this->formUrl = request()->fullUrl();

        $this->invitationId = request()->get('invitation');
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::auth.register-form', [
            'invitation' => $this->invitationId ? Models::invitation()::findByUuid($this->invitationId) : null,
        ]);
    }

    public function canSubmit(): bool
    {
        $requiredProperties = ['name', 'username', 'email', 'password', 'password_confirmation', 'terms'];

        foreach ($requiredProperties as $property) {
            if (! $this->$property) {
                return false;
            }
        }

        return $this->getErrorBag()->count() === 0;
    }
}
