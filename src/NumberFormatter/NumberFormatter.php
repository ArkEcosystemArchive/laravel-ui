<?php

namespace ARKEcosystem\UserInterface\NumberFormatter;

use ARKEcosystem\UserInterface\NumberFormatter\Concerns\HasAttributes;
use ARKEcosystem\UserInterface\NumberFormatter\Concerns\HasCustomFormatters;
use ARKEcosystem\UserInterface\NumberFormatter\Concerns\HasFormatters;
use ARKEcosystem\UserInterface\NumberFormatter\Concerns\HasPadding;
use ARKEcosystem\UserInterface\NumberFormatter\Concerns\HasParsers;
use ARKEcosystem\UserInterface\NumberFormatter\Concerns\HasRounding;
use ARKEcosystem\UserInterface\NumberFormatter\Concerns\HasSymbol;
use ARKEcosystem\UserInterface\NumberFormatter\Concerns\HasTextAttributes;
use NumberFormatter as NativeFormatter;

final class NumberFormatter
{
    use HasAttributes;
    use HasCustomFormatters;
    use HasFormatters;
    use HasPadding;
    use HasParsers;
    use HasRounding;
    use HasSymbol;
    use HasTextAttributes;

    private string $locale = 'en_US';

    private int $style = NativeFormatter::DECIMAL;

    private NativeFormatter $formatter;

    private function __construct(
        string $locale,
        int $style,
        array $attributes = [],
        array $textAttributes = [],
        array $symbols = []
    ) {
        $this->locale    = $locale;
        $this->style     = $style;
        $this->formatter = new NativeFormatter($locale, $style);

        foreach ($attributes as $attribute => $value) {
            $this->setAttribute($attribute, $value);
        }

        foreach ($textAttributes as $attribute => $value) {
            $this->setTextAttribute($attribute, $value);
        }

        foreach ($symbols as $symbol => $value) {
            $this->setSymbol($symbol, $value);
        }
    }

    public static function new(string $locale = 'en_US', int $style = NativeFormatter::DECIMAL): self
    {
        return new static($locale, $style);
    }

    public function withLocale(string $locale): self
    {
        return new static(
            $locale,
            $this->style,
            $this->attributes,
            $this->textAttributes,
            $this->symbols
        );
    }

    public function withStyle(int $style): self
    {
        return new static(
            $this->locale,
            $style,
            $this->attributes,
            $this->textAttributes,
            $this->symbols
        );
    }
}
