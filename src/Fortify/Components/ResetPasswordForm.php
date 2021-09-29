<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Components;

use ARKEcosystem\Fortify\Components\Concerns\ValidatesPassword;
use ARKEcosystem\Fortify\Models;
use Livewire\Component;

class ResetPasswordForm extends Component
{
    use ValidatesPassword;

    public $token;

    public ?string $twoFactorSecret;

    public ?string $email = '';

    public ?string $password = '';

    public ?string $password_confirmation = '';

    public function mount(?string $token = null, ?string $email = null)
    {
        $this->token = $token;

        if ($email !== null) {
            $this->email = $email;

            $user = Models::user()::where('email', $email)->firstOrFail();

            $this->twoFactorSecret = $user->two_factor_secret;
        }
    }

    /**
     * Render the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('ark-fortify::auth.reset-password-form');
    }
}
