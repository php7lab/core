<?php

namespace PhpLab\Core\Libs\Container;

use Psr\Container\ContainerInterface;

trait ContainerAwareTrait
{

    /**
     * @var ContainerInterface
     */
    protected $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

}
