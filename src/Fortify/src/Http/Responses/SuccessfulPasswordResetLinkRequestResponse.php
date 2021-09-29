<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Http\Responses\SuccessfulPasswordResetLinkRequestResponse as LaravelSuccessfulPasswordResetLinkRequestResponse;

class SuccessfulPasswordResetLinkRequestResponse extends LaravelSuccessfulPasswordResetLinkRequestResponse
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
        flash()->success(__('pages.user-settings.reset_link_email'));

        return $request->wantsJson()
                    ? new JsonResponse(['message' => trans($this->status)], 200)
                    : back()->with('status', trans($this->status));
    }
}
