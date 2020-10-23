<?php

namespace ARKEcosystem\UserInterface;

class UI
{
    private static array $errorMessages = [];

    public static function bootErrorMessages(): void
    {
        foreach ([401, 403, 404, 419, 429, 500, 503] as $code) {
            static::useErrorMessage($code, trans('ui::errors.'.$code));
        }
    }

    public static function getErrorMessage(int $code): string
    {
        return static::$errorMessages[$code];
    }

    public static function useErrorMessage(int $code, string $message): void
    {
        static::$errorMessages[$code] = $message;
    }
}
