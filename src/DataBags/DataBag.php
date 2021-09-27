<?php

namespace ARKEcosystem\UserInterface\DataBags;

use ARKEcosystem\UserInterface\DataBags\Resolvers\ControllerResolver;
use ARKEcosystem\UserInterface\DataBags\Resolvers\DomainResolver;
use ARKEcosystem\UserInterface\DataBags\Resolvers\GlobResolver;
use ARKEcosystem\UserInterface\DataBags\Resolvers\NameResolver;
use ARKEcosystem\UserInterface\DataBags\Resolvers\PathResolver;
use ARKEcosystem\UserInterface\DataBags\Resolvers\RegexResolver;

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
