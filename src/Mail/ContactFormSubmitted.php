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
        $primaryAddress = config('mail.support.address', config('mail.stub.address'));

        $mail = $this
            ->subject(trans('mails.subjects.contact_form'))
            ->markdown('mails.contact-form-submitted');

        if ($this->data['subject'] === 'job_application') {
            $mail
                ->to(config('mail.jobs_stub.address'))
                ->cc($primaryAddress);
        } elseif ($this->data['subject'] === 'partnership_enquiry') {
            $mail
                ->to(config('mail.pba_stub.address'))
                ->cc($primaryAddress);
        } else {
            $mail->to($primaryAddress);
        }

        return $mail;
    }
}
