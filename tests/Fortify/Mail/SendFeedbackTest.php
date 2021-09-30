<?php

declare(strict_types=1);

use ARKEcosystem\Foundation\Fortify\Mail\SendFeedback;
use Illuminate\Support\Facades\Mail;

it('sends the mail to the marketsquare team', function () {
    Mail::fake();

    Mail::to(config('fortify.mail.feedback'))->send(new SendFeedback('feedback'));

    Mail::assertQueued(SendFeedback::class, fn ($mail) => $mail->hasTo(config('fortify.mail.feedback.address')));
});

it('builds the mail with sender', function () {
    $mail = new SendFeedback('feedback');

    expect($mail->build()->from)->toBe([config('fortify.mail.default')]);
});

it('builds the mail with subject', function () {
    $mail = new SendFeedback('feedback');

    expect($mail->build()->subject)->toBe(trans('fortify::mails.feedback_subject'));
});
