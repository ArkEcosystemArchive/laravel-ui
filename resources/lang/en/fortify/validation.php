<?php

declare(strict_types=1);

return [
    'password_doesnt_match'            => 'The provided password does not match your current password.',
    'password_doesnt_match_records'    => 'This password does not match our records.',
    'password_reset_link_invalid'      => 'Your password reset link expired or is invalid.',
    'password_leaked'                  => 'Your password appears to have been leaked.',

    'messages' => [
        'one_time_password'                                   => 'We were not able to enable two-factor authentication with this one-time password.',
        'some_special_characters'                             => "The :attribute can only contain letters, numbers and . & - , '",
        'include_letters'                                     => 'The :attribute needs at least one letter',
        'start_with_letter_or_number'                         => 'The :attribute must start with a letter or a number',

        'username' => [
            'special_character_start'         => 'Username must not start or end with special characters',
            'special_character_end'           => 'Username must not start or end with special characters',
            'consecutive_special_characters'  => 'Username must not contain consecutive special characters',
            'forbidden_special_characters'    => 'Username must only contain letters, numbers and _ .',
            'max_length'                      => 'Username may not have more than :length characters.',
            'min_length'                      => 'Username must be at least :length characters.',
            'lowercase_only'                  => 'Username must be lowercase characters.',
            'blacklisted'                     => 'This :attribute is unavailable.',
        ],
    ],
];
