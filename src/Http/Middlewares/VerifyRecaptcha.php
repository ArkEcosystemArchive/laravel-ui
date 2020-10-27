<?php

namespace ARKEcosystem\UserInterface\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;

class VerifyRecaptcha
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->get('g-recaptcha-response')) {
            return $this->handleError($request);
        }

        $recaptcha = new ReCaptcha(config('services.recaptcha.secret'));

        if (! $recaptcha->verify($request->get('g-recaptcha-response'), $request->ip())->isSuccess()) {
            return $this->handleError($request);
        }

        return $next($request);
    }

    private function handleError($request)
    {
        if ($request->wantsJson()) {
            abort(400);
        }

        flash()->error('We need to know that you are not a robot.');

        return back()->withInput();
    }
}
