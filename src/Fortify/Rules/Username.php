<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Rules;

use ARKEcosystem\Foundation\Fortify\Rules\Concerns\ReservedUsername;
use ARKEcosystem\Foundation\Fortify\Support\Enums\Constants;
use Illuminate\Support\Str;
use Laravel\Fortify\Rules\Password as Fortify;

class Username extends Fortify
{
    /**
     * Indicates if the username contains some forbidden special characters.
     *
     * @var bool
     */
    protected $withForbiddenSpecialChars = false;

    /**
     * Indicates if the username contains a special character at the start of it.
     *
     * @var bool
     */
    protected $withSpecialCharAtTheStart = false;

    /**
     * Indicates if the username contains a special character at the end of it.
     *
     * @var bool
     */
    protected $withSpecialCharAtTheEnd = false;

    /**
     * Indicates if the username contains consecutive special characters.
     *
     * @var bool
     */
    protected $withConsecutiveSpecialChars = false;

    /**
     * Indicates if the username contains consecutive special characters.
     *
     * @var bool
     */
    protected $hasReachedMaxLength = false;

    /**
     * Indicates if the username contains any uppercase character.
     *
     * @var bool
     */
    protected $hasUpperCaseCharacters = false;

    /**
     * Indicates if the username contains any reserved name.
     *
     * @var bool
     */
    protected $withReservedName = false;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Handle potential NULL values
        $value = $value ?: '';

        if ($this->withForbiddenSpecialChars($value)) {
            $this->withForbiddenSpecialChars = true;

            return false;
        }

        if ($this->withSpecialCharAtTheStart($value)) {
            $this->withSpecialCharAtTheStart = true;

            return false;
        }

        if ($this->withSpecialCharAtTheEnd($value)) {
            $this->withSpecialCharAtTheEnd = true;

            return false;
        }

        if ($this->withConsecutiveSpecialChars($value)) {
            $this->withConsecutiveSpecialChars = true;

            return false;
        }

        if ($this->needsMaximumLength($value)) {
            $this->hasReachedMaxLength = true;

            return false;
        }

        if ($this->needsLowercase($value)) {
            $this->hasUpperCaseCharacters = true;

            return false;
        }

        if ($this->withReservedName($attribute, $value)) {
            $this->withReservedName = true;

            return false;
        }

        return ! $this->needsMinimumLength($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        switch (true) {
            case $this->withSpecialCharAtTheStart:
                return trans('ui::validation.messages.username.special_character_start');

            case $this->withSpecialCharAtTheEnd:
                return trans('ui::validation.messages.username.special_character_end');

            case $this->withConsecutiveSpecialChars:
                return trans('ui::validation.messages.username.consecutive_special_characters');

            case $this->withForbiddenSpecialChars:
                return trans('ui::validation.messages.username.forbidden_special_characters');

            case $this->hasReachedMaxLength:
                return trans('ui::validation.messages.username.max_length', [
                    'length' => Constants::MAX_USERNAME_CHARACTERS,
                ]);

            case $this->hasUpperCaseCharacters:
                return trans('ui::validation.messages.username.lowercase_only');

            case $this->withReservedName:
                return ReservedUsername::message();

            default:
                return trans('ui::validation.messages.username.min_length', [
                    'length' => Constants::MIN_USERNAME_CHARACTERS,
                ]);
        }
    }

    public function withForbiddenSpecialChars(string $value): bool
    {
        return preg_match('/[^\w.]/', $value) === 1;
    }

    public function withSpecialCharAtTheStart(string $value): bool
    {
        return preg_match('/^\W|^[_|\.]/', $value) === 1;
    }

    public function withSpecialCharAtTheEnd(string $value): bool
    {
        return preg_match('/\W$|[_|\.]$/', $value) === 1;
    }

    public function withConsecutiveSpecialChars(string $value): bool
    {
        return preg_match('/^[^a-zA-Z0-9]?(?>[a-zA-Z0-9]+[^a-zA-Z0-9])*[a-zA-Z0-9]*$/', $value) === 0;
    }

    public function needsMinimumLength(string $value): bool
    {
        return Str::length($value) < Constants::MIN_USERNAME_CHARACTERS;
    }

    public function needsMaximumLength(string $value): bool
    {
        return Str::length($value) > Constants::MAX_USERNAME_CHARACTERS;
    }

    public function needsLowercase(string $value): bool
    {
        return $value !== strtolower($value);
    }

    private function withReservedName($attribute, $value): bool
    {
        return ! ReservedUsername::passes($attribute, $value);
    }
}
