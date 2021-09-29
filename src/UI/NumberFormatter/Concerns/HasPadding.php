<?php

namespace ARKEcosystem\UserInterface\NumberFormatter\Concerns;

use NumberFormatter;

trait HasPadding
{
    public function withPaddingAfterPrefix(): self
    {
        return $this->setAttribute(NumberFormatter::PADDING_POSITION, NumberFormatter::PAD_AFTER_PREFIX);
    }

    public function withPaddingAfterSuffix(): self
    {
        return $this->setAttribute(NumberFormatter::PADDING_POSITION, NumberFormatter::PAD_AFTER_SUFFIX);
    }

    public function withPaddingBeforePrefix(): self
    {
        return $this->setAttribute(NumberFormatter::PADDING_POSITION, NumberFormatter::PAD_BEFORE_PREFIX);
    }

    public function withPaddingBeforeSuffix(): self
    {
        return $this->setAttribute(NumberFormatter::PADDING_POSITION, NumberFormatter::PAD_BEFORE_SUFFIX);
    }
}
