<?php

declare(strict_types=1);

return [
    'custom' => [
        'max_markdown_chars' => 'The text may not be greater than :max characters.',
        'invalid_tag' => 'Only letters and numbers are allowed, the tag must start with a letter and must be between 3 and 30 characters.',
    ],

    'tag' => [
        'special_character_start'        => 'The tag must start with a letter.',
        'special_character_end'          => 'The tag must end with a letter.',
        'consecutive_special_characters' => 'The tag must not contain consecutive special characters.',
        'min_length'                     => 'The tag must be between 3 and 30 characters.',
        'max_length'                     => 'The tag must be between 3 and 30 characters.',
        'lowercase_only'                 => 'The tag must be lowercased.',
        'forbidden_special_characters'   => 'The tag must only contain letters, numbers, spaces and -'
    ],
];
