<?php

declare(strict_types=1);

use function Tests\createAttributes;
use Tests\Mocks\MediaMock;

it('should render the component', function (): void {
    $this
        ->assertView('ark::navbar.profile', createAttributes([
            'profilePhoto'     => new MediaMock('https://imgur.com/abc123'),
            'profileMenu'      => [],
        ]))
        ->contains('src="https://imgur.com/abc123"');
});

it('should render the [profileMenuClass] attribute', function (): void {
    $this
        ->assertView('ark::navbar.profile', createAttributes([
            'profilePhoto'     => new MediaMock('https://imgur.com/abc123'),
            'profileMenu'      => [],
            'profileMenuClass' => 'unicorn',
        ]))
        ->contains('src="https://imgur.com/abc123"')
        ->contains('unicorn');
});

it('should render the [identifier] attribute instead of the [profilePhoto] attribute', function (): void {
    $this
        ->assertView('ark::navbar.profile', createAttributes([
            'profilePhoto' => new MediaMock('https://imgur.com/abc123'),
            'profileMenu'  => [],
            'identifier'   => 'unicorn',
        ]))
        ->contains('avatar-wrapper');
});
