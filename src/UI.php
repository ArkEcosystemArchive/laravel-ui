<?php

namespace ARKEcosystem\UserInterface;

class UI
{
    private static array $errorMessages = [
        401 => 'Something went wrong, please try again later or get in touch if the issue persists!',
        403 => 'Something went wrong, please try again later or get in touch if the issue persists!',
        404 => 'Something went wrong, please try again later or get in touch if the issue persists!',
        419 => 'Something went wrong, please try again later or get in touch if the issue persists!',
        429 => 'Something went wrong, please try again later or get in touch if the issue persists!',
        500 => 'Something went wrong, please try again later or get in touch if the issue persists!',
        503 => 'Something went wrong, please try again later or get in touch if the issue persists!',
    ];

    public static function getErrorMessage(int $code): string
    {
        return static::$errorMessages[$code];
    }

    public static function useErrorMessage(int $code, string $message): void
    {
        static::$errorMessages[$code] = $message;
    }
}
