<?php

namespace PhpLab\Core\Libs\ArrayTools\Repositories\Base;

use php7rails\domain\interfaces\repositories\CrudInterface;
use php7rails\domain\repositories\BaseRepository;
use PhpLab\Core\Libs\ArrayTools\Traits\ArrayModifyTrait;
use PhpLab\Core\Libs\ArrayTools\Traits\ArrayReadTrait;

abstract class BaseActiveArrayRepository extends BaseRepository implements CrudInterface
{

    use ArrayReadTrait;
    use ArrayModifyTrait;

    private $collection = [];

    protected function setCollection(Array $collection)
    {
        $this->collection = $collection;
    }

    protected function getCollection()
    {
        return $this->collection;
    }
}
