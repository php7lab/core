<?php

namespace PhpLab\Core\Libs\Container;

use Psr\Container\ContainerInterface;

interface ContainerAwareInterface
{

    /**
     * Sets the container.
     */
    public function setContainer(ContainerInterface $container = null);

}
