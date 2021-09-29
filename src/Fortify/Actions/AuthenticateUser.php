<?php

declare(strict_types=1);

namespace ARKEcosystem\Fortify\Actions;

use ARKEcosystem\Fortify\Models;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Fortify;

class AuthenticateUser
{
    protected Request $request;

    /**
     * @var \Illuminate\Http\Request
     */
    public function __construct(Request $request)
    {
        $this->request     = $request;
        $this->username    = Fortify::username();
        $this->usernameAlt = Config::get('fortify.username_alt');
    }

    public function handle(): ?Authenticatable
    {
        /** @var \Illuminate\Database\Eloquent\Model */
        $user = $this->fetchUser();

        if (! $user) {
            return null;
        }

        if (! Hash::check($this->request->password, $user->password)) {
            return null;
        }

        $user->update(['last_login_at' => Carbon::now()]);

        return $user;
    }

    private function fetchUser(): ?Authenticatable
    {
        $username = $this->getUsername();

        $query = Models::user()::query();

        $query->whereRaw(sprintf('LOWER(%s) = ?', Fortify::username()), [$username]);

        if ($usernameAlt = Config::get('fortify.username_alt')) {
            $query->orWhereRaw(sprintf('LOWER(%s) = ?', $usernameAlt), [$username]);
        }

        return $query->first();
    }

    private function getUsername(): ?string
    {
        return strtolower($this->request->get($this->username));
    }
}
