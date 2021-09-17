<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Livewire\Exceptions\ComponentNotFoundException;
use Livewire\LivewireManager;

final class DropInvalidLivewireRequests
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->routeIs('livewire.*') || ! app()->bound(LivewireManager::class)) {
            return $next($request);
        }

        if (! $this->containsValidPayload($request)) {
            // Throwing 404 Not Found for some reason doesn't work as Livewire doesn't know how to intercept the 404, as it actually expects a response (WTF, Caleb?). (I guess as this wasn't working before with 404).
            // If 403 is thrown, Livewire knows to actually throw back 403 to browser.
            abort(403);
        }

        if (! $this->isValidComponent($request->input('fingerprint.name'))) {
            abort(403);
        }

        return $next($request);
    }

    /**
     * We want to drop all Livewire requests that want to manipulate on a component that doesn't even exist.
     *
     * @param string $component
     * @return bool
     */
    private function isValidComponent(string $component) : bool
    {
        try {
            return app(LivewireManager::class)->getClass($component) !== null;
        } catch (ComponentNotFoundException $e) {
            return false;
        }
    }

    /**
     * A valid Livewire request should contain fingerprint data (ID, method) and stuff like checksum.
     *
     * @param \Illuminate\Http\Request $request
     * @return bool
     */
    private function containsValidPayload(Request $request) : bool
    {
        return $request->has(['fingerprint.id', 'fingerprint.method', 'fingerprint.name', 'fingerprint.path'])
            && $request->has(['serverMemo.checksum', 'serverMemo.htmlHash']);
    }
}
