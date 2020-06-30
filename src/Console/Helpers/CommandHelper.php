<?php

namespace PhpLab\Core\Console\Helpers;

use Illuminate\Contracts\Container\BindingResolutionException;
use PhpLab\Core\Helpers\ComposerHelper;
use PhpLab\Core\Legacy\Yii\Helpers\FileHelper;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

class CommandHelper
{

    public static function registerFromNamespaceList(array $namespaceList, ContainerInterface $container)
    {
        foreach ($namespaceList as $namespace) {
            self::registerFromNamespace($namespace, $container);
        }
    }

    public static function registerFromNamespace(string $namespace, ContainerInterface $container)
    {
        $path = ComposerHelper::getPsr4Path($namespace);
        $files = FileHelper::scanDir($path);

        $commands = array_map(function ($item) use ($namespace) {
            $item = str_replace('.php', '', $item);
            return $namespace . '\\' . $item;
        }, $files);

        foreach ($commands as $commandClassName) {
            try {
                $commandInstance = $container->get($commandClassName);
                /** @var Application $application */
                $application = $container->get(Application::class);
                $application->add($commandInstance);
            } catch (\Throwable $e) {}
        }
    }

}
