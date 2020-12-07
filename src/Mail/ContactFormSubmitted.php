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
        $mail = $this
            ->subject(trans('mails.subjects.contact_form'))
            ->markdown('mails.contact-form-submitted');

        if ($this->data['subject'] === 'job_application') {
            $mail
                ->to(config('mail.jobs_stub.address'))
                ->cc(config('mail.stub.address'));
        } elseif ($this->data['subject'] === 'partnership_enquiry') {
            $mail
                ->to(config('mail.pba_stub.address'))
                ->cc(config('mail.stub.address'));
        } else {
            $mail->to(config('mail.stub.address'));
        }

        return $mail;
    }
}
