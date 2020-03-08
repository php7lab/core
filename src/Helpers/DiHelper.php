<?php

namespace PhpLab\Core\Helpers;

use PhpLab\Core\Libs\Container\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface as SymfonyContainerAwareInterface;
use Psr\Container\ContainerInterface;

class DiHelper
{

    public static function make(string $className, ContainerInterface $container = null): object {
        $instance = new $className;
        if($instance instanceof ContainerAwareInterface || $instance instanceof SymfonyContainerAwareInterface) {
            $instance->setContainer($container);
        }
        return $instance;
    }

}