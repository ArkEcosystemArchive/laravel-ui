<?php

declare(strict_types=1);

use function Tests\createAttributes;

it('should render the component', function (): void {
    $this
        ->assertView('ark::navbar.hamburger', createAttributes([]))
        ->contains('flex items-center');
});
