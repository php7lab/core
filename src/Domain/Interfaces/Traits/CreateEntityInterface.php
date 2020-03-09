<?php

namespace PhpLab\Core\Domain\Interfaces\Traits;

interface CreateEntityInterface
{

    /**
     * @param array $attributes
     * @return object
     */
    public function createEntity(array $attributes = []);

}