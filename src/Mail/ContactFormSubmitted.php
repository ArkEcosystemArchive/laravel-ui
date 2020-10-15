<?php

namespace ARKEcosystem\UserInterface\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

class ContactFormSubmitted extends Mailable implements ShouldQueue
{
    use Queueable;

    public $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function build()
    {
        return $this
            ->to(config('mail.stub.address'))
            ->subject(trans('mails.subjects.contact_form'))
            ->markdown('mail.contact-form-submitted');
    }
}
