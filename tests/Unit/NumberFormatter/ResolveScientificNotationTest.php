<?php

declare(strict_types=1);

use ARKEcosystem\UserInterface\NumberFormatter\ResolveScientificNotation;

it('should resolve the scientification notation if it is present', function (): void {
    expect(ResolveScientificNotation::execute(123))->toBe('123');
    expect(ResolveScientificNotation::execute(1E8))->toBe('100000000');
    expect(ResolveScientificNotation::execute(2.555E-5))->toBe('0.00002555');
});
