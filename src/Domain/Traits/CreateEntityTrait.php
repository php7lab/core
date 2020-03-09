<?php

namespace PhpLab\Core\Domain\Traits;

use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Helpers\InstanceHelper;

trait CreateEntityTrait
{

    public function createEntity(array $attributes = [])
    {
        $entityClass = $this->getEntityClass();
        $entityInstance = InstanceHelper::create($entityClass);
        if ($attributes) {
            EntityHelper::setAttributes($entityInstance, $attributes);
        }
        return $entityInstance;
    }

}