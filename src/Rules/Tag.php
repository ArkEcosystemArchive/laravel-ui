<?php

namespace ARKEcosystem\UserInterface\Rules;

use ARKEcosystem\UserInterface\Support\Enums\Constants;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Str;

class Tag implements Rule
{
    /**
     * Indicates if the username contains some forbidden special characters.
     *
     * @var bool
     */
    protected $withForbiddenSpecialChars = false;

    /**
     * Indicates if the tag contains a special character at the start of it.
     *
     * @var bool
     */
    protected $withSpecialCharAtTheStart = false;

    /**
     * Indicates if the tag contains a special character at the end of it.
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
     * Indicates if the tag contains consecutive special characters.
     *
     * @var bool
     */
    protected $hasReachedMaxLength = false;

    public function passes($attribute, $value): bool
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

        return ! $this->needsMinimumLength($value);
    }

    public function message()
    {
        switch (true) {
            case $this->withSpecialCharAtTheStart:
                return trans('ui::validation.tag.special_character_start');

            case $this->withSpecialCharAtTheEnd:
                return trans('ui::validation.tag.special_character_end');

            case $this->withConsecutiveSpecialChars:
                return trans('ui::validation.tag.consecutive_special_characters');

            case $this->withForbiddenSpecialChars:
                return trans('ui::validation.tag.forbidden_special_characters');

            case $this->hasReachedMaxLength:
                return trans('ui::validation.tag.max_length', [
                    'length' => Constants::MAX_TAG_LENGTH,
                ]);

            default:
                return trans('ui::validation.tag.min_length', [
                    'length' => Constants::MIN_TAG_LENGTH,
                ]);
        }
    }

    public function withForbiddenSpecialChars(string $value): bool
    {
        return preg_match('/^[A-Za-z0-9 -]*$/', $value) === 0;
    }

    public function withSpecialCharAtTheStart(string $value): bool
    {
        return preg_match('/^[A-Za-z]/', $value) === 0;
    }

    public function withSpecialCharAtTheEnd(string $value): bool
    {
        return preg_match('/[A-Za-z]$/', $value) === 0;
    }

    public function withConsecutiveSpecialChars(string $value): bool
    {
        return preg_match('/[ -]{2,}/', $value) === 1;
    }

    public function needsMinimumLength(string $value): bool
    {
        return Str::length($value) < Constants::MIN_TAG_LENGTH;
    }

    public function needsMaximumLength(string $value): bool
    {
        return Str::length($value) > Constants::MAX_TAG_LENGTH;
    }
}
