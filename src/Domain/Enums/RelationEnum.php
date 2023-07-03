<?php

namespace PhpLab\Core\Domain\Enums;

use PhpLab\Core\Domain\Base\BaseEnum;

class RelationEnum extends BaseEnum
{

    const ONE = 'one';
    const MANY = 'many';
    const MANY_TO_MANY = 'many-to-many';
    const CALLBACK = 'callback';

}
