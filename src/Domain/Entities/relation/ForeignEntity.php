<?php

namespace PhpLab\Core\Domain\Entities\relation;

/**
 * Class ForeignEntity
 *
 * @package PhpLab\Core\Domain\Entities\relation
 *
 * @property $field
 * @property $value
 */
class ForeignEntity extends BaseForeignEntity
{

    public $field = 'id';
    public $value;

}