<?php

declare(strict_types=1);

return [
    'user-settings' => [
        '2fa_title'                         => 'Two Factor Authentication',
        '2fa_description'                   => 'Add additional security to your account using two factor authentication.',
        '2fa_enabled_title'                 => 'You have enabled two factor authentication.',
        '2fa_not_enabled_title'             => 'You have not enabled two factor authentication.',
        '2fa_summary'                       => "When two factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone's :link1 or :link2 application.",
        'one_time_password'                 => 'One-Time Password',
        '2fa_reset_code_title'              => 'Two-Factor Authentication Recovery Codes',
        '2fa_reset_code_description'        => 'Reset Code',
        '2fa_warning_text'                  => 'If you lose your two-factor authentication device, you may use these emergency recovery codes to sign-in to your MarketSquare account. <strong>Each reset code can only be used once.</strong>',
        'reset_link_email'                  => 'Request submitted. If your email address is associated with an account, you will receive an email with instructions on how to reset your password.',
        'update_timezone_title'             => 'Timezone',
        'update_timezone_description'       => 'Select a Timezone below and update it by clicking the update button.',
        'timezone_updated'                  => 'Timezone was successfully updated',
        'data_exported'                     => 'We are processing your request. You should shortly receive an email with your data.',
        'password_information_title'        => 'Password',
        'password_information_description'  => 'Ensure your account is using a long, random password to stay secure.',
        'contact_information_title'         => 'Contact Information',
        'contact_information_description'   => "Update your account's contact information and email address.",
        'gdpr_title'                        => 'General Data Protection Regulation (GDPR)',
        'gdpr_description'                  => 'This will will create a zip containing all personal data to respect your right to data portability. You will receive the zip file on the email address linked to your account.',
        'delete_account_title'              => 'Account Deletion',
        'delete_account_description'        => 'Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.',
        'update_password_alert_description' => 'The Security Settings allow you to change your passwords and enable or disable 2FA. Please remember the changes made for when you next sign in.',
        'password_updated'                  => 'Password was successfully updated',
    ],

    'feedback_thank_you' => [
        'title'       => 'Thank you for your feedback',
        'description' => 'We\'re sorry to see you go. You can return anytime by creating a new account.',
        'home_page'   => 'Return Home',
    ],
];
