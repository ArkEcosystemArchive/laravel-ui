<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Rules\Concerns;

trait ValidatesEmptyString
{
    public function stripZeroWidthSpaces(string $text): string
    {
        // Zero-width characters to remove, source: http://jkorpela.fi/chars/spaces.html
        $regex = '/[\x{2000}-\x{200D}\x{FEFF}\x{0020}\x{00A0}\x{3000}\x{205F}\x{202F}\x{00A0}\x{180B}-\x{180F}]/u';

        return preg_replace($regex, '', $text);
    }
}
