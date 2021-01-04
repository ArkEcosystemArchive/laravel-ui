<?php

use function Tests\createAttributes;

it('should render the component', function (): void {
    $this
        ->assertView('ark::navbar.hamburger', createAttributes([]))
        ->contains('flex items-center pr-6 border-r border-theme-secondary-300');
});
