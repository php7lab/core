<?php

namespace PhpLab\Core\Helpers;

use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use PhpLab\Core\Legacy\Yii\Helpers\FileHelper;

class ComposerHelper
{

    private static $autoload_psr4;

    public static function getPsr4Path($path)
    {
        self::ensure();
        $path = self::normalizePath($path);
        $pathItems = explode('\\', $path);

        $paths = self::find($pathItems);

        return ArrayHelper::first($paths);
    }

    private static function find(array $pathItems): array
    {
        $paths = [];
        $pp = '';
        for($i = 0; $i <= count($pathItems) - 1; $i++) {
            $pp .= $pathItems[$i] . '\\';
            unset($pathItems[$i]);
            $dirs = ArrayHelper::getValue(self::$autoload_psr4, $pp);
            if($dirs) {
                foreach ($dirs as $dir) {
                    $relativeDir = implode('\\', $pathItems);
                    $path = trim($dir. '\\' . $relativeDir, '\\');
                    $paths[$pp . $relativeDir] = $path;
                }
            }
        }
        return $paths;
    }

    private static function normalizePath(string $path): string
    {
        $path = str_replace('/', '\\', $path);
        $path = trim($path, '\\@');
        return $path;
    }
    
    private static function ensure()
    {
        if (self::$autoload_psr4) {
            return;
        }
        self::$autoload_psr4 = include FileHelper::rootPath() . '/vendor/composer/autoload_psr4.php';
    }

}