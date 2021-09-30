<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Actions;

use ARKEcosystem\Foundation\Fortify\Rules\DisplayNameCharacters;
use ARKEcosystem\Foundation\Fortify\Rules\OneLetter;
use ARKEcosystem\Foundation\Fortify\Rules\StartsWithLetterOrNumber;
use ARKEcosystem\Foundation\Fortify\Support\Enums\Constants;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param mixed $user
     * @param array $input
     *
     * @return void
     */
    public function update($user, array $input)
    {
        Validator::make($input, [
            'name'  => [
                'required',
                'max:'.Constants::MAX_DISPLAY_NAME_CHARACTERS,
                'min:'.Constants::MIN_DISPLAY_NAME_CHARACTERS,
                new DisplayNameCharacters(),
                new OneLetter(),
                new StartsWithLetterOrNumber(),
            ],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        ])->validateWithBag('updateProfileInformation');

        $newEmail = strtolower($input['email']);
        $oldEmail = strtolower($user->email);
        if ($newEmail !== $oldEmail && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else {
            $user->forceFill([
                'name'  => $input['name'],
                'email' => $newEmail,
            ])->save();
        }
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param mixed $user
     * @param array $input
     *
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name'              => $input['name'],
            'email'             => strtolower($input['email']),
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
