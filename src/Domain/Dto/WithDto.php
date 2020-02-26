<?php

namespace PhpLab\Core\Domain\Dto;

use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Domain\Entities\relation\RelationEntity;

class WithDto
{

    /**
     * @var Query
     */
    public $query;
    public $remain;
    public $remainOfRelation;
    public $relationName;

    /**
     * @var RelationEntity
     */
    public $relationConfig;
    public $passed;
    public $withParams;

}