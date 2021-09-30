<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Fortify;

class Models
{
    /**
     * Get the user model that is used by the application.
     *
     * @return string
     */
    public static function user(): string
    {
        return config('fortify.models.user');
    }

    /**
     * Get the invitation model that is used by the application.
     *
     * @return string
     */
    public static function invitation(): string
    {
        return config('fortify.models.invitation');
    }
}
