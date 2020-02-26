<?php

namespace PhpLab\Core\Domain\Base;

use PhpLab\Core\Domain\Interfaces\GetEntityClassInterface;
use PhpLab\Core\Domain\Traits\ForgeEntityTrait;

abstract class BaseRepository implements GetEntityClassInterface
{

    use ForgeEntityTrait;

}