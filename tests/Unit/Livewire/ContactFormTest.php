<?php

use ARKEcosystem\UserInterface\Components\ContactForm;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Livewire\Livewire;

it('can automatically fill the message of the contact form if the subject is related to desktop wallet plugin report', function () {
    $config = [
        'subjects' => [
            [
                'label' => 'Technical Support',
                'value' => 'technical_support',
            ],
            [
                'label' => 'Desktop Wallet Plugin Report',
                'value' => 'desktop_wallet_plugin_report',
            ],
        ],
    ];

    Config::set('web.contact.subjects', Arr::get($config, 'subjects'));

    Livewire::test(ContactForm::class)
        ->assertSet('subject', 'technical_support')
        ->assertSet('message', null)
        ->set('subject', 'desktop_wallet_plugin_report')
        ->assertSet('message', "Hi, I would like to report a plugin. The ID is  and version is . The issue I've encountered is ...");
});