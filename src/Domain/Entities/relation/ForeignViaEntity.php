<?php

namespace PhpLab\Core\Domain\Entities\relation;

/**
 * Class ForeignViaEntity
 *
 * @package PhpLab\Core\Domain\Entities\relation
 *
 * @property $self
 * @property $foreign
 */
class ForeignViaEntity extends BaseForeignEntity
{

    public $self;
    public $foreign;

}