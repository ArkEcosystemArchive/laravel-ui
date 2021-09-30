<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\UserInterface\DataBags;

use ARKEcosystem\Foundation\UserInterface\DataBags\Resolvers\ControllerResolver;
use ARKEcosystem\Foundation\UserInterface\DataBags\Resolvers\DomainResolver;
use ARKEcosystem\Foundation\UserInterface\DataBags\Resolvers\GlobResolver;
use ARKEcosystem\Foundation\UserInterface\DataBags\Resolvers\NameResolver;
use ARKEcosystem\Foundation\UserInterface\DataBags\Resolvers\PathResolver;
use ARKEcosystem\Foundation\UserInterface\DataBags\Resolvers\RegexResolver;

final class DataBag
{
    private static array $bags = [];

    public static function register(string $key, array $data): void
    {
        static::$bags[$key] = $data;
    }

    /**
     * @return mixed
     */
    public static function resolveByController(string $key)
    {
        return (new ControllerResolver())->resolve(static::$bags, $key);
    }

    /**
     * @return mixed
     */
    public static function resolveByDomain(string $key)
    {
        return (new DomainResolver())->resolve(static::$bags, $key);
    }

    /**
     * @return mixed
     */
    public static function resolveByName(string $key)
    {
        return (new NameResolver())->resolve(static::$bags, $key);
    }

    /**
     * @return mixed
     */
    public static function resolveByPath(string $key)
    {
        return (new PathResolver())->resolve(static::$bags, $key);
    }

    /**
     * @return mixed
     */
    public static function resolveByGlob(string $key)
    {
        return (new GlobResolver())->resolve(static::$bags, $key);
    }

    /**
     * @return mixed
     */
    public static function resolveByRegex(string $key)
    {
        return (new RegexResolver())->resolve(static::$bags, $key);
    }
}
