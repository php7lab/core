<?php

namespace PhpLab\Core\Domain\Libs\Relation;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Domain\Helpers\EntityHelper;
use Symfony\Component\PropertyAccess\PropertyAccess;

class OneToMany
{

    public $foreignContainerField;
    public $selfModel;

    //public $foreignField;
    public $selfField;
    public $foreignModel;

    public function run(Collection $collection)
    {
        $selfPkName = $this->selfModel->primaryKey()[0];
        $targetIds = EntityHelper::getColumn($collection, $selfPkName);
        $targetIds = array_unique($targetIds);
        $targetPkName = $this->foreignModel->primaryKey()[0];
        $query = new Query;
        $query->where(\PhpLab\Core\Legacy\Yii\Helpers\Inflector::underscore($this->selfField), $targetIds);
        /** @var Collection $targetCollection */
        $targetCollection = $this->foreignModel->all($query);
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($collection as $selfEntity) {
            $selfPkValue = $propertyAccessor->getValue($selfEntity, $selfPkName);
            $relationCollection = new Collection;
            foreach ($targetCollection as $foreignEntity) {
                $indexValue = $propertyAccessor->getValue($foreignEntity, $this->selfField);
                if ($selfPkValue == $indexValue) {
                    $relationCollection->add($foreignEntity);
                }
            }
            $propertyAccessor->setValue($selfEntity, $this->foreignContainerField, $relationCollection);
        }
    }

}