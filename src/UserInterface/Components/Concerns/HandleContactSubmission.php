<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Components\Concerns;

use ARKEcosystem\Foundation\UserInterface\Mail\ContactFormSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

trait HandleContactSubmission
{
    public function handleContactSubmission(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'max:64'],
            'email'   => ['required', 'email'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'max:2048'],
        ]);

        Mail::send(new ContactFormSubmitted($data));

        flash()->success(trans('pages.support.form_submitted'));

        return back();
    }
}
