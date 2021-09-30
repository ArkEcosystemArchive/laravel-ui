<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify\Http\Responses;

use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Contracts\SuccessfulPasswordResetLinkRequestResponse;
use Laravel\Fortify\Http\Responses\FailedPasswordResetLinkRequestResponse as LaravelFailedPasswordResetLinkRequestResponse;

class FailedPasswordResetLinkRequestResponse extends LaravelFailedPasswordResetLinkRequestResponse
{
    /**
     * Create an HTTP response that represents the object.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function toResponse($request)
    {
        // If the status is related to a user that doesn't exist, we show a successful
        // status to prevent people from determining the registered users based on
        // the error message.
        if (in_array($this->status, [Password::RESET_LINK_SENT, Password::INVALID_USER], true)) {
            return app(SuccessfulPasswordResetLinkRequestResponse::class, ['status' => $this->status])->toResponse($request);
        }

        return parent::toResponse($request);
    }
}
