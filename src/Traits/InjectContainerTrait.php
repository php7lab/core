<?php

namespace PhpLab\Core\Traits;

use Psr\Container\ContainerInterface;

trait InjectContainerTrait
{

    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    protected function getContainer(): ContainerInterface
    {
        return $this->container;
    }

}
