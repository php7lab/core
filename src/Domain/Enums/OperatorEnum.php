<?php

namespace PhpLab\Core\Domain\Enums;

use PhpLab\Core\Domain\Base\BaseEnum;

class OperatorEnum extends BaseEnum
{

    const EQUAL = '=';
    const NOT_EQUAL = '<>';
    //const NOT_EQUAL = '!=';
    const LESS = '<';
    const GREATER = '>';
    const LIKE = 'like';

    /*'=', '<', '>', '<=', '>=', '<>', '!=',
    'like', 'not like', 'between', 'ilike', 'not ilike',
    '~', '&', '|', '#', '<<', '>>', '<<=', '>>=',
    '&&', '@>', '<@', '?', '?|', '?&', '||', '-', '-', '#-',
    'is distinct from', 'is not distinct from',*/

}
