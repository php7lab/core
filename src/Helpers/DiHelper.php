<?php

namespace PhpLab\Core\Helpers;

use Psr\Container\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class DiHelper
{

    public static function make(string $className, ContainerInterface $container = null): object {
        $instance = new $className;
        if($instance instanceof ContainerAwareInterface) {
            $instance->setContainer($container);
        }
        return $instance;
    }

}