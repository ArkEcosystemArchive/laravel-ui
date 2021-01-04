<?php

use function Tests\createAttributes;

it('should render the component', function (): void {
    $this
        ->assertView('ark::navbar.profile', createAttributes([
            'profilePhoto'     => 'https://imgur.com/abc123',
            'profileMenu'      => [],
        ]))
        ->contains('src="https://imgur.com/abc123"');
});

it('should render the [profileMenuClass] attribute', function (): void {
    $this
        ->assertView('ark::navbar.profile', createAttributes([
            'profilePhoto'     => 'https://imgur.com/abc123',
            'profileMenu'      => [],
            'profileMenuClass' => 'unicorn',
        ]))
        ->contains('src="https://imgur.com/abc123"')
        ->contains('unicorn');
});

it('should render the [identifier] attribute instead of the [profilePhoto] attribute', function (): void {
    $this
        ->assertView('ark::navbar.profile', createAttributes([
            'profilePhoto' => 'https://imgur.com/abc123',
            'profileMenu'  => [],
            'identifier'   => 'unicorn',
        ]))
        ->contains('x-html="avatarImage"');
});
