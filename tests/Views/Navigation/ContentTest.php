<?php

use Illuminate\Foundation\Auth\User;

it('should render the [profile] slot', function (): void {
    $this
        ->actingAs(new User())
        ->assertView('ark::navbar.content', [
            'profile' => 'profile slot',
        ])
        ->contains('profile slot');
});
