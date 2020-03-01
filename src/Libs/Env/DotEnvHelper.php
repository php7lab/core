<?php

namespace PhpLab\Core\Libs\Env;

use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use RuntimeException;
use Symfony\Component\Dotenv\Dotenv;

class DotEnvHelper
{

    const ROOT_PATH = __DIR__ . '/../../../../../..';

    static private $map = [];

    public static function init(string $basePath = self::ROOT_PATH): void
    {
        if (self::loadCachedEnvLocal($basePath)) {
            return;
        }
        if ( ! class_exists(Dotenv::class)) {
            throw new RuntimeException('Please run "composer require symfony/dotenv" to load the ".env" files configuring the application.');
        }
        $dotEnv = new Dotenv(false);
        // load all the .env files
        $dotEnv->loadEnv($basePath . '/.env');
    }

    public static function get(string $path = null, $default = null)
    {
        if (empty(self::$map)) {
            self::forgeMap();
        }
        return ArrayHelper::getValue(self::$map, $path, $default);
    }

    private static function forgeMap(): void
    {
        foreach ($_ENV as $name => $value) {
            $pureName = $name;
            $pureName = strtolower($pureName);
            $pureName = str_replace('_', '.', $pureName);
            ArrayHelper::set(self::$map, $pureName, $value);
        }
    }

    private static function loadCachedEnvLocal(string $basePath): bool
    {
        // Load cached env vars if the .env.local.php file exists
        // Run "composer dump-env prod" to create it (requires symfony/flex >=1.2)
        $env = @include $basePath . '/.env.local.php';
        if ( ! is_array($env)) {
            return false;
        }
        foreach ($env as $key => $value) {
            self::setEnvValue($key, $value);
        }
        return true;
    }

    private static function setEnvValue(string $key, $value): void
    {
        if(isset($_ENV[$key])) {
            return;
        }
        $isHeader = 0 === strpos($key, 'HTTP_');
        $hasValueInServer = isset($_SERVER[$key]) && ! $isHeader;
        $_ENV[$key] = $hasValueInServer ? $_SERVER[$key] : $value;
    }

}