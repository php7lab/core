<?php

namespace PhpLab\Core\Domain\Interfaces\Traits;

interface CreateEntityInterface
{

    /**
     * Создать сущность
     *
     * Создавать новые сущности должен уметь только сервис
     *
     * @param array $attributes
     * @return object
     */
    public function createEntity(array $attributes = []);

}