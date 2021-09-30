<?php

declare(strict_types=1);

return [
    'do_not_show_message_again'     => 'Do not show this message again.',
    'attachment_pdf'                => 'Attachment (.PDF)',
    'email'                         => 'E-Mail Address',
    'message'                       => 'Message',
    'name'                          => 'Name',
    'subject'                       => 'Subject',
    'github_markdown_can_be_used'   => '* Github flavored markdown can be used',
    'wysiwyg'                       => [
        'words'        => 'Words',
        'characters'   => 'Characters',
        'reading_time' => 'Reading time',
        'min'          => 'min',
    ],

    'upload-image' => [
        'upload_image' => 'Upload Image',
        'delete_image' => 'Delete Image',
        'min_size'     => 'Min :0 x :1',
        'max_filesize' => 'Max filesize :0',
        'upload_error' => 'Failed to upload image. Image size cannot be greater than 2MB and must be of type jpeg, png or svg.',
    ],

    'upload-image-collection' => [
        'drag_drop_browse' => '<span class="hidden md:inline">Drag & Drop your files here or</span> <a @click="select()" class="link">Browse Files</a>',
        'delete_image'     => 'Delete Image',
        'requirements'     => '<span>Min size :width x :height. Max filesize :filesize.</span> <span>Max :quantity images</span>',
    ],

    // Fortify
    'confirm_password'         => 'Confirm Password',
    'current_password'         => 'Current Password',
    'email_address'            => 'Email Address',
    'email'                    => 'Email',
    'name'                     => 'Name',
    'new_password'             => 'New Password',
    'password'                 => 'Password',
    'username'                 => 'Username',
    'display_name'             => 'Display Name',
    'code'                     => 'Code',
    '2fa_code'                 => '2FA Verification Code',
    'recovery_code'            => 'Recovery Code',
    'confirm_username'         => 'Your Username',
    'optional'                 => 'optional',

    'update-password' => [
        'requirements_notice' => 'Password must be 12–128 characters, and include a number, a symbol, a lower and an upper case letter.',
    ],

    'password-rules' => [
        'lowercase'         => 'One lowercase character',
        'uppercase'         => 'One uppercase character',
        'numbers'           => 'One number',
        'symbols'           => 'One special character',
        'min'               => '12 characters minumum',
        'leak'              => 'No match in leaked database',
    ],

    'delete-user' => [
        'title'                    => 'Delete Account',
        'confirmation'             => 'Deleting your account will also delete all Projects you own from MarketSquare, and these actions are permanent. Confirm your username below or click Cancel to go back.',
        'confirmation_placeholder' => 'Enter your username to confirm deletion',
    ],

    'logout-sessions' => [
        'title'          => 'Browser Sessions',
        'description'    => 'Manage and logout your active sessions on other browsers and devices.',
        'content'        => 'If necessary, you may logout of all of your other browser sessions across all of your devices. If you feel your account has been compromised, you should also update your password',
        'confirm_logout' => 'Logout Other Browser Sessions',
    ],

    'confirming-logout' => [
        'title'          => 'Logout Other Browser Sessions',
        'content'        => 'Please enter your password to confirm you would like to logout of your other browser sessions across all of your devices.',
    ],

    'upload-avatar' => [
        'upload_avatar' => 'Upload Avatar',
        'delete_avatar' => 'Delete Avatar',
    ],

    'feedback' => [
        'label'       => 'Feedback',
        'placeholder' => 'Provide feedback and help us...',
    ],

    'confirm-password' => [
        'title'        => '2FA Recovery Codes',
        'description'  => 'Input your password to show your emergency two-factor recovery codes.',
    ],

    'disable-2fa' => [
        'title'        => 'Disable 2FA',
        'description'  => 'Input your password to disable the two-factor authentication method.',
    ],
];
