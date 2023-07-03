<?php

namespace PhpLab\Core\Domain\Strategies\join\handlers;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Dto\WithDto;
use PhpLab\Core\Domain\Entities\relation\RelationEntity;

interface HandlerInterface
{

    public function join(Collection $collection, RelationEntity $relationEntity);

    public function load(object $entity, WithDto $w, $relCollection): RelationEntity;

}
