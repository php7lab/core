<?php

namespace PhpLab\Core\Domain\Interfaces\Entity;

interface ValidateEntityInterface
{

    /**
     * @return array
     */
    public function validationRules();

}