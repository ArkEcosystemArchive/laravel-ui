<?php

return [
    'attachment_pdf'                => 'Attachment (.PDF)',
    'email'                         => 'E-Mail Address',
    'message'                       => 'Message',
    'name'                          => 'Name',
    'subject'                       => 'Subject',
    'github_markdown_can_be_used'   => '* Github flavored markdown can be used',

    'upload-image' => [
        'upload_image' => 'Upload Image',
        'delete_image' => 'Delete Image',
        'min_size'     => 'Min :0 x :1',
        'max_filesize' => 'Max filesize :0',
        'upload_error' => 'Uploading error. Image size may not be greater than 2048 kilobytes and must be of type jpeg, png or svg.',
    ],

    'upload-image-collection' => [
        'drag_drop_browse' => '<span class="hidden md:inline">Drag & Drop your files here or</span> <a @click="select()" class="link">Browse Files</a>',
        'delete_image'     => 'Delete Image',
        'requirements'     => '<span>Min size :width x :height. Max filesize :filesize.</span> <span>Max :quantity images</span>',
    ],
];
