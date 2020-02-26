<?php

namespace PhpLab\Core\Domain\Interfaces\Service;

use PhpLab\Core\Domain\Interfaces\DataProviderInterface;
use PhpLab\Core\Domain\Interfaces\GetEntityClassInterface;
use PhpLab\Core\Domain\Interfaces\ReadAllInterface;

interface CrudServiceInterface extends DataProviderInterface, ServiceInterface, GetEntityClassInterface, ReadAllInterface, ReadOneInterface, ModifyInterface
{


}