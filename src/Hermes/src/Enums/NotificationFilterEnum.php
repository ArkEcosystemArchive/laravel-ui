<?php

declare(strict_types=1);

namespace ARKEcosystem\Hermes\Enums;

final class NotificationFilterEnum
{
    public const ALL = 'all';

    public const READ = 'read';

    public const UNREAD = 'unread';

    public const STARRED = 'starred';

    public const UNSTARRED = 'unstarred';

    public static function isAll(string $value):bool
    {
        return $value === static::ALL;
    }
}
