<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Rules;

use ARKEcosystem\Fortify\Rules\Concerns\ReservedUsername;
use Illuminate\Contracts\Validation\Rule;

final class DisplayNameCharacters implements Rule
{
    /**
     * Indicates if the display name contains forbidden characters.
     *
     * @var bool
     */
    protected bool $withForbiddenChars = false;

    /**
     * Indicates if the display name contains reserved name.
     *
     * @var bool
     */
    protected bool $withReservedName = false;

    /**
     * Indicates if the display name contains repetitive special chars.
     *
     * @var bool
     */
    protected bool $withRepetitiveSpecialChars = false;

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed  $value
     *
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        if ($this->withForbiddenChars($value)) {
            $this->withForbiddenChars = true;

            return false;
        }

        if ($this->withRepetitiveSpecialChars($value)) {
            $this->withRepetitiveSpecialChars = true;

            return false;
        }

        if ($this->withReservedName($attribute, $value)) {
            $this->withReservedName = true;

            return false;
        }

        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        if ($this->withReservedName) {
            return ReservedUsername::message();
        }

        if ($this->withRepetitiveSpecialChars) {
            return trans('fortify::validation.messages.some_special_characters');
        }

        return trans('fortify::validation.messages.some_special_characters');
    }

    public function withForbiddenChars(string $value): bool
    {
        // Some (unicode letter or number and . , - ' ’ &
        return preg_match('/^[\p{L}\p{N}\p{Mn} .,\-\'’&]+$/u', $value) === 0;
    }

    private function withReservedName($attribute, $value): bool
    {
        return ! ReservedUsername::passes($attribute, $value);
    }

    public function withRepetitiveSpecialChars(string $value): bool
    {
        return preg_match('/([.,\-\'’&])\1/u', $value) === 1;
    }
}
