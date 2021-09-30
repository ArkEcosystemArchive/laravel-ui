<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;

final class SendFeedback extends Mailable implements ShouldQueue
{
    use Queueable;

    public string $message;

    public function __construct(string $message)
    {
        $this->message = $message;
    }

    public function build(): self
    {
        return $this
            ->from(config('fortify.mail.default.address'), config('fortify.mail.default.name'))
            ->subject(trans('fortify::mails.feedback_subject'))
            ->markdown('ark-fortify::mails.profile.feedback');
    }
}
