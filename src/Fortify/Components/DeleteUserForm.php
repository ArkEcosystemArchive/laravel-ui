<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Components;

use ARKEcosystem\Foundation\Fortify\Contracts\DeleteUser;
use ARKEcosystem\Foundation\Fortify\Mail\SendFeedback;
use ARKEcosystem\Foundation\UserInterface\Http\Livewire\Concerns\HasModal;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Livewire\Component;

class DeleteUserForm extends Component
{
    use HasModal;

    public string $username;

    public string $usernameConfirmation = '';

    public string $feedback = '';

    protected $rules = [
        'feedback' => 'present|string|min:5|max:500',
    ];

    public function mount()
    {
        $this->username = Auth::user()->username;
    }

    public function confirmUserDeletion()
    {
        $this->dispatchBrowserEvent('confirming-delete-user');

        $this->usernameConfirmation = '';
        $this->openModal();
    }

    public function hasConfirmedName(): bool
    {
        return $this->username === $this->usernameConfirmation;
    }

    public function deleteUser(DeleteUser $deleter, StatefulGuard $auth)
    {
        if ($this->hasConfirmedName()) {
            $redirect = $this->sendFeedback();

            $deleter->delete(Auth::user()->fresh());

            $auth->logout();

            $this->redirect($redirect);
        }
    }

    private function sendFeedback(): string
    {
        if ($this->feedback !== '' && $this->validate()) {
            Mail::to(config('fortify.mail.feedback.address'))->send(new SendFeedback($this->feedback));

            return URL::temporarySignedRoute('profile.feedback.thank-you', now()->addMinutes(15));
        }

        return route('home');
    }

    public function render()
    {
        return view('ark-fortify::profile.delete-user-form');
    }
}
