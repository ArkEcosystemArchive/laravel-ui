<?php

it('should render the component', function (): void {
    $this
        ->assertView('ark::navbar.dropdown.notifications', [
            'indicator' => 'indicator',
            'slot'      => 'list of notifications',
        ])
        ->contains('list of notifications');
});

it('should render the [dropdownClasses] attribute', function (): void {
    $this
        ->assertView('ark::navbar.dropdown.notifications', [
            'indicator'       => 'indicator',
            'slot'            => 'list of notifications',
            'dropdownClasses' => 'unicorn',
        ])
        ->contains('list of notifications')
        ->contains('unicorn');
});
