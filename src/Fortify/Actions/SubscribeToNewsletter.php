<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Actions;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Spatie\Newsletter\NewsletterFacade as Newsletter;

final class SubscribeToNewsletter
{
    public static function execute(?string $email, string $list): bool
    {
        Validator::make(compact('email', 'list'), [
            'email' => ['required', 'email'],
            'list'  => ['required', 'string', Rule::in(array_keys(config('newsletter.lists')))],
        ])->validate();

        if (Newsletter::isSubscribed($email, $list)) {
            return false;
        }

        return Newsletter::subscribePending($email, [], $list) !== false;
    }
}
