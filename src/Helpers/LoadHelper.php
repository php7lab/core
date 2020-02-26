<?php

namespace PhpLab\Core\Helpers;

use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use PhpLab\Core\Legacy\Yii\Helpers\FileHelper;

class LoadHelper
{

    public static function loadScript(string $fileName)
    {
        return @include(FileHelper::path($fileName));
    }

    public static function loadConfigList(array $fileNames, array $config = []): array
    {
        foreach ($fileNames as $fileName) {
            $itemConfig = self::loadScript($fileName);
            if(is_array($itemConfig)) {
                $config = ArrayHelper::merge($config, $itemConfig);
            }
        }
        return $config;
    }

}