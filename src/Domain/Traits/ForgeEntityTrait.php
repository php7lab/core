<?php

namespace PhpLab\Core\Domain\Traits;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Helpers\EntityHelper;

trait ForgeEntityTrait
{

    //protected $entityClass = '';

    public function getEntityClass(): string
    {
        return $this->entityClass;
    }

    protected function forgeEntityCollection(array $array): Collection
    {
        $entityClass = $this->getEntityClass();
        return EntityHelper::createEntityCollection($entityClass, $array);
    }

    protected function forgeEntity($item): object
    {
        $entityClass = $this->getEntityClass();
        $entity = new $entityClass;
        EntityHelper::setAttributes($entity, $item);
        return $entity;
    }

}