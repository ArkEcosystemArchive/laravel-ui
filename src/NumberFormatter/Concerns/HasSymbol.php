<?php

namespace ARKEcosystem\UserInterface\NumberFormatter\Concerns;

use NumberFormatter;

trait HasSymbol
{
    private array $symbols = [];

    public function withDecimalSeparatorSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::DECIMAL_SEPARATOR_SYMBOL, $value);
    }

    public function withGroupingSeparatorSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::GROUPING_SEPARATOR_SYMBOL, $value);
    }

    public function withPatternSeparatorSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::PATTERN_SEPARATOR_SYMBOL, $value);
    }

    public function withPercentSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::PERCENT_SYMBOL, $value);
    }

    public function withZeroDigitSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::ZERO_DIGIT_SYMBOL, $value);
    }

    public function withDigitSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::DIGIT_SYMBOL, $value);
    }

    public function withMinusSignSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::MINUS_SIGN_SYMBOL, $value);
    }

    public function withPlusSignSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::PLUS_SIGN_SYMBOL, $value);
    }

    public function withCurrencySymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::CURRENCY_SYMBOL, $value);
    }

    public function withIntlCurrencySymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::INTL_CURRENCY_SYMBOL, $value);
    }

    public function withMonetarySeparatorSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::MONETARY_SEPARATOR_SYMBOL, $value);
    }

    public function withExponentialSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::EXPONENTIAL_SYMBOL, $value);
    }

    public function withPermillSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::PERMILL_SYMBOL, $value);
    }

    public function withPadEscapeSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::PAD_ESCAPE_SYMBOL, $value);
    }

    public function withInfinitySymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::INFINITY_SYMBOL, $value);
    }

    public function withNanSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::NAN_SYMBOL, $value);
    }

    public function withSignificantDigitSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::SIGNIFICANT_DIGIT_SYMBOL, $value);
    }

    public function withMonetaryGroupingSeparatorSymbol(string $value): self
    {
        return $this->setSymbol(NumberFormatter::MONETARY_GROUPING_SEPARATOR_SYMBOL, $value);
    }

    private function setSymbol(int $symbol, string $value): self
    {
        $this->formatter->setSymbol($symbol, $value);
        $this->symbols[$symbol] = $value;

        return $this;
    }
}
