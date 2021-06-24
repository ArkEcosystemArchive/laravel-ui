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
];
