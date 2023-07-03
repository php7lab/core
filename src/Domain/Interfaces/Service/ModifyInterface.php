<?php

namespace PhpLab\Core\Domain\Interfaces\Service;

use PhpLab\Core\Domain\Exceptions\UnprocessibleEntityException;
use PhpLab\Core\Domain\Interfaces\Entity\EntityIdInterface;
use PhpLab\Core\Exceptions\NotFoundException;

interface ModifyInterface
{

    /**
     * @param array $data
     * @return EntityIdInterface
     * @throws UnprocessibleEntityException
     */
    public function create($data): EntityIdInterface;

    /**
     * @param int $id
     * @param array $data
     * @throws NotFoundException
     * @throws UnprocessibleEntityException
     */
    public function updateById($id, $data);

    /**
     * @param int $id
     * @throws NotFoundException
     */
    public function deleteById($id);

}