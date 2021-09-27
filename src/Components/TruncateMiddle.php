<?php

namespace ARKEcosystem\UserInterface\Components;

use Illuminate\Support\Arr;
use Illuminate\View\Component;

final class TruncateMiddle extends Component
{
    public function render(): \Closure
    {
        return function (array $data): string {
            $value     = trim((string) $data['slot']);
            $maxLength = Arr::get($data, 'attributes.length', 10);

            if (strlen($value) <= $maxLength) {
                return $value;
            }

            $partLength = (int) floor(($maxLength) / 2);

            $parts[] = substr($value, 0, $partLength);
            $parts[] = substr($value, -$partLength);

            return implode('…', $parts);
        };
    }
}
