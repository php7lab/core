<?php

namespace PhpLab\Core\Domain\Base;

use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Domain\Interfaces\Traits\CreateEntityInterface;
use PhpLab\Core\Domain\Interfaces\GetEntityClassInterface;
use PhpLab\Core\Domain\Traits\CreateEntityTrait;
use PhpLab\Core\Helpers\InstanceHelper;

abstract class BaseService implements GetEntityClassInterface, CreateEntityInterface
{

    use CreateEntityTrait;

    protected $repository;

    /**
     * @return GetEntityClassInterface
     */
    protected function getRepository()
    {
        return $this->repository;
    }

    protected function setRepository($repository)
    {
        $this->repository = $repository;
    }

    public function getEntityClass(): string
    {
        return $this->getRepository()->getEntityClass();
    }

}