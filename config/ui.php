<?php

return [
    'wysiwyg' => [
        'folder' => 'wysiwyg',
        'disk'   => 'public',
    ],

    'crop-image' => [
        'validation' => ['required', 'image'],
        'folder'     => 'livewire-tmp',
        'disk'       => 'local',
    ],

    'upload' => [
        'accept-mime' => 'image/jpg,image/jpeg,image/png',
    ],

    /*
    |--------------------------------------------------------------------------
    | Avatar generation media conversions
    |--------------------------------------------------------------------------
    */
    'media' => [
        // If you change these values ensure to run `php artisan media-library:regenerate`
        // to regenerate the images
        'conversions' => [
            'mini' => 18,
            'small' => 42,
            'medium-small' => 80,
            'medium' => 96,
            'large' => 120,
            'base' => 142,
        ],
        'srcset_sizes' => [2, 3, 4],
    ],
];
