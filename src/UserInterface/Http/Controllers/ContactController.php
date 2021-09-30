<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\Http\Controllers;

use ARKEcosystem\Foundation\UserInterface\Mail\ContactFormSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

final class ContactController extends Controller
{
    public function index(Request $request): View
    {
        $validator = Validator::make($request->all(), [
            'subject'        => ['string', Rule::in($this->getSubjects())],
            'plugin_id'      => ['string', 'max:64'],
            'plugin_version' => ['string', 'max:32'],
        ]);

        if ($validator->fails()) {
            abort(422);
        }

        $subject = $request->subject;
        $message = '';

        if ($subject === 'desktop_wallet_plugin_report') {
            $message .= "Hi, I would like to report a plugin. The ID is {$request->plugin_id} and version is {$request->plugin_version}. The issue I've encountered is ...";
        }

        return view('app.contact', compact('message', 'subject'));
    }

    public function handle(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'       => ['required', 'max:64'],
            'email'      => ['required', 'email'],
            'subject'    => ['required', 'string', Rule::in($this->getSubjects())],
            'message'    => ['required', 'max:2048'],
            'attachment' => ['mimes:pdf', 'max:1024'],
        ]);

        $mail = new ContactFormSubmitted(Arr::except($data, ['attachment']));

        if ('job_application' === $data['subject']) {
            if ($request->has('attachment')) {
                $attachment = $request->file('attachment');

                $mail->attach($attachment->getRealPath(), [
                    'as'   => $attachment->getClientOriginalName(),
                    'mime' => 'application/pdf',
                ]);
            }
        }

        Mail::send($mail);

        flash()->success(trans('messages.contact'));

        return redirect()->route('contact');
    }

    private function getSubjects(): Collection
    {
        return collect(config('web.contact.subjects'))->pluck('value');
    }
}
