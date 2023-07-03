<?php

namespace PhpLab\Core\Patterns\Singleton;

class SingletonTrait implements SingletonInterface
{

    /**
     * @var static[]|array
     */
    private static $instances = [];

    public static function instance(): object
    {
        $refresh = false;
        $className = static::class;
        $isNotFound = ! isset(self::$instances[$className]);
        if ($refresh || $isNotFound) {
            self::$instances[$className] = new $className;
        }
        return self::$instances[$className];
    }

}