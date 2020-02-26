<?php

namespace PhpLab\Core\Domain\Strategies\join\handlers;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Dto\WithDto;
use PhpLab\Core\Domain\Entities\relation\RelationEntity;

class Callback extends Base implements HandlerInterface
{

    public function join(Collection $collection, RelationEntity $relationEntity)
    {
        call_user_func_array($relationEntity->callback, [$collection]);

    }

    public function load(object $entity, WithDto $w, $relCollection): RelationEntity
    {

    }

}