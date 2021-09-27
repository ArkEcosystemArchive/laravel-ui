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

    /*
     * Upload image validation.
     */
    'upload' => [
        /*
         * Validation applied to a single image upload component.
         */
        'image-single' => [
            'accept-mime' => 'image/jpg,image/jpeg,image/png,jpg,png',
            // This filesize is used in the backend validation.
            // Keep in mind that the image is compressed in the frontend component
            // and it will be always less than this value.
            'max-filesize' => 5120,
            'dimensions'   => [
                'min-width'  => 148,
                'min-height' => 148,
                'max-width'  => 5000,
                'max-height' => 5000,
            ],
        ],

        /*
         * Validation applied to a multiple images upload component.
         */
        'image-collection' => [
            'accept-mime' => 'image/jpg,image/jpeg,image/png,jpg,png',
            // This filesize is used in the backend validation.
            // Keep in mind that the image is compressed in the frontend component
            // and it will be always less than this value.
            'max-filesize' => 5120,
            'dimensions'   => [
                'min-width'  => 148,
                'min-height' => 148,
                'max-width'  => 5000,
                'max-height' => 5000,
            ],
        ],
    ],
];
