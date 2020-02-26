<?php

namespace PhpLab\Core\Domain\Interfaces\Service;

use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Exceptions\NotFoundException;

interface ReadOneInterface
{

    /**
     * @param $id
     * @param Query|null $query
     * @return object
     * @throws NotFoundException
     */
    public function oneById($id, Query $query = null);

}