<?php

namespace PhpLab\Core\Domain\Base;

use PhpLab\Core\Domain\Interfaces\GetEntityClassInterface;

abstract class BaseService implements GetEntityClassInterface
{

    protected $repository;

    /**
     * @return GetEntityClassInterface
     */
    public function getRepository()
    {
        return $this->repository;
    }

    public function getEntityClass(): string
    {
        return $this->getRepository()->getEntityClass();
    }
}