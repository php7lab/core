<?php

namespace PhpLab\Core\Libs\ArrayTools\Repositories\Base;

use php7rails\domain\interfaces\repositories\CrudInterface;
use PhpLab\Core\Libs\ArrayTools\Traits\ArrayModifyTrait;
use PhpLab\Core\Libs\ArrayTools\Traits\ArrayReadTrait;

abstract class BaseActiveDiscRepository extends BaseDiscRepository implements CrudInterface
{

    use ArrayReadTrait;
    use ArrayModifyTrait;

}