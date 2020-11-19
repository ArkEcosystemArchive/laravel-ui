<?php

it('should render the component', function (): void {
    $this
        ->assertView('ark::navbar.notifications', [
            'notificationsIndicator' => 'indicator',
            'notifications'          => 'list of notifications',
        ])
        ->contains('list of notifications');
});

it('should render the [dropdownClasses] attribute', function (): void {
    $this
        ->assertView('ark::navbar.notifications', [
            'notificationsIndicator' => 'indicator',
            'notifications'          => 'list of notifications',
            'dropdownClasses'        => 'unicorn',
        ])
        ->contains('list of notifications')
        ->contains('unicorn');
});
