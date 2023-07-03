<?php

namespace PhpLab\Core\Domain\Interfaces\Repository;

use PhpLab\Core\Domain\Interfaces\GetEntityClassInterface;
use PhpLab\Core\Domain\Interfaces\ReadAllInterface;

interface CrudRepositoryInterface extends RepositoryInterface, GetEntityClassInterface, ReadAllInterface, ReadOneInterface, ModifyInterface, RelationConfigInterface
{


}