<?php

namespace ARKEcosystem\UserInterface\NumberFormatter\Concerns;

use NumberFormatter;

trait HasAttributes
{
    private array $attributes = [];

    public function withParseIntOnly(int | float $value): self
    {
        return $this->setAttribute(NumberFormatter::PARSE_INT_ONLY, $value);
    }

    public function withGroupingUsed(int | float $value): self
    {
        return $this->setAttribute(NumberFormatter::GROUPING_USED, $value);
    }

    public function withDecimalAlwaysShown(int | float $value): self
    {
        return $this->setAttribute(NumberFormatter::DECIMAL_ALWAYS_SHOWN, $value);
    }

    public function withMaxIntegerDigits(int $value): self
    {
        return $this->setAttribute(NumberFormatter::MAX_INTEGER_DIGITS, $value);
    }

    public function withMinIntegerDigits(int $value): self
    {
        return $this->setAttribute(NumberFormatter::MIN_INTEGER_DIGITS, $value);
    }

    public function withIntegerDigits(int $value): self
    {
        return $this->setAttribute(NumberFormatter::INTEGER_DIGITS, $value);
    }

    public function withMaxFractionDigits(int $value): self
    {
        return $this->setAttribute(NumberFormatter::MAX_FRACTION_DIGITS, $value);
    }

    public function withMinFractionDigits(int $value): self
    {
        return $this->setAttribute(NumberFormatter::MIN_FRACTION_DIGITS, $value);
    }

    public function withFractionDigits(int $value): self
    {
        return $this->setAttribute(NumberFormatter::FRACTION_DIGITS, $value);
    }

    public function withMultiplier(int $value): self
    {
        return $this->setAttribute(NumberFormatter::MULTIPLIER, $value);
    }

    public function withGroupingSize(int $value): self
    {
        return $this->setAttribute(NumberFormatter::GROUPING_SIZE, $value);
    }

    // @TODO
    public function withRoundingIncrement(int $value): self
    {
        return $this->setAttribute(NumberFormatter::ROUNDING_INCREMENT, $value);
    }

    public function withFormatWidth(int $value): self
    {
        return $this->setAttribute(NumberFormatter::FORMAT_WIDTH, $value);
    }

    public function withSecondaryGroupingSize(int $value): self
    {
        return $this->setAttribute(NumberFormatter::SECONDARY_GROUPING_SIZE, $value);
    }

    public function withSignificantDigitsUsed(int $value): self
    {
        return $this->setAttribute(NumberFormatter::SIGNIFICANT_DIGITS_USED, $value);
    }

    public function withMinSignificantDigits(int $value): self
    {
        return $this->setAttribute(NumberFormatter::MIN_SIGNIFICANT_DIGITS, $value);
    }

    public function withMaxSignificantDigits(int $value): self
    {
        return $this->setAttribute(NumberFormatter::MAX_SIGNIFICANT_DIGITS, $value);
    }

    public function withLenientParse(int $value): self
    {
        return $this->setAttribute(NumberFormatter::LENIENT_PARSE, $value);
    }

    private function setAttribute(int $attribute, int $value): self
    {
        $this->formatter->setAttribute($attribute, $value);
        $this->attributes[$attribute] = $value;

        return $this;
    }
}
