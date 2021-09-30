<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Actions;

use ARKEcosystem\Foundation\Fortify\Models;
use ARKEcosystem\Foundation\Fortify\Rules\DisplayNameCharacters;
use ARKEcosystem\Foundation\Fortify\Rules\OneLetter;
use ARKEcosystem\Foundation\Fortify\Rules\StartsWithLetterOrNumber;
use ARKEcosystem\Foundation\Fortify\Rules\Username;
use ARKEcosystem\Foundation\Fortify\Support\Enums\Constants;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Validator as Illuminate;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Fortify;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param array $input
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function create(array $input)
    {
        $input      = $this->buildValidator($input)->validate();
        $invitation = null;

        if (array_key_exists('invitation', $input)) {
            $invitationId = $input['invitation'];
            unset($input['invitation']);
            $invitation = Models::invitation()::findByUuid($invitationId);
        }

        return DB::transaction(function () use ($input, $invitation) {
            $user = Models::user()::create($this->getUserData($input));

            if ($invitation) {
                $invitation->update(['user_id' => $user->id]);

                $user->markEmailAsVerified();
            }

            return $user;
        });
    }

    public static function createValidationRules(): array
    {
        $rules = [
            'name'              => [
                'required',
                'max:'.Constants::MAX_DISPLAY_NAME_CHARACTERS,
                'min:'.Constants::MIN_DISPLAY_NAME_CHARACTERS,
                new DisplayNameCharacters(),
                new OneLetter(),
                new StartsWithLetterOrNumber(),
            ],
            Fortify::username() => static::usernameRules(),
            'password'          => static::passwordRules(),
            'terms'             => ['required', 'accepted'],
            'invitation'        => ['sometimes', 'required', 'string'],
        ];

        if ($usernameAlt = Config::get('fortify.username_alt')) {
            $rules[$usernameAlt] = [
                'required', 'string', 'unique:users', resolve(Username::class),
            ];
        }

        return $rules;
    }

    private function buildValidator(array $input): Illuminate
    {
        return Validator::make($input, static::createValidationRules());
    }

    public function getUserData(array $input): array
    {
        $userData = [
            'name'              => $input['name'],
            Fortify::username() => strtolower($input[Fortify::username()]),
            'password'          => Hash::make($input['password']),
        ];

        if ($usernameAlt = Config::get('fortify.username_alt')) {
            $userData[$usernameAlt] = strtolower($input[$usernameAlt]);
        }

        return $userData;
    }

    protected static function usernameRules(): array
    {
        $rules = ['required', 'string', 'max:255', 'unique:users'];

        if (Fortify::username() === 'email') {
            $rules[] = 'email';
        }

        return $rules;
    }
}
