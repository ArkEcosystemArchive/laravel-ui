<?php

namespace ARKEcosystem\UserInterface\Rules;

use ARKEcosystem\UserInterface\Support\Concerns\HandlesMarkdown;
use Illuminate\Contracts\Validation\Rule;

class MarkdownMaxChars implements Rule
{
    use HandlesMarkdown;

    private int $maxChars;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(int $maxChars)
    {
        $this->maxChars = $maxChars;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  string  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->count($value)['characters'] <= $this->maxChars;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('ui::validation.custom.max_markdown_chars', ['max' => $this->maxChars]);
    }
}
