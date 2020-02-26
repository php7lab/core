<?php

namespace PhpLab\Core\Domain\Entities\Query;

use PhpLab\Core\Domain\Enums\OperatorEnum;

class Where
{

    public $column;
    public $operator = OperatorEnum::EQUAL;
    public $value = null;
    public $boolean = 'and';
    public $not = false;

}
