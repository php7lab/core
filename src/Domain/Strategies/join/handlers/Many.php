<?php

namespace PhpLab\Core\Domain\Strategies\join\handlers;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Domain\Dto\WithDto;
use PhpLab\Core\Domain\Entities\relation\RelationEntity;
use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Domain\Helpers\Repository\RelationRepositoryHelper;
use PhpLab\Core\Libs\ArrayTools\Helpers\ArrayIterator;
use Symfony\Component\PropertyAccess\PropertyAccess;

class Many extends Base implements HandlerInterface
{

    public function join(Collection $collection, RelationEntity $relationEntity)
    {
        $values = self::getColumn($collection, $relationEntity->field);

        $query = Query::forge();
        $query->where($relationEntity->foreign->field, $values);

        $relCollection = RelationRepositoryHelper::getAll($relationEntity->foreign, $query);
        return $relCollection;
    }

    public function load(object $entity, WithDto $w, $relCollection): RelationEntity
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $fieldValue = $propertyAccessor->getValue($entity, $w->relationConfig->field);
        //$fieldValue = $entity->{$w->relationConfig->field};
        if (empty($fieldValue)) {
            return $w->relationConfig;
        }
        $query = Query::forge();
        $query->where($w->relationConfig->foreign->field, $fieldValue);
        $data = ArrayIterator::allFromArray($query, $relCollection);
        $data = self::prepareValue($data, $w);
        $propertyAccessor->setValue($entity, $w->relationName, $data);
        //EntityHelper::setAttribute($entity, $w->relationName, $data);
        //$entity->{$w->relationName} = $data;
        return $w->relationConfig;
    }

}