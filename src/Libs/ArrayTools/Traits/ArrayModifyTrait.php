<?php

namespace PhpLab\Core\Libs\ArrayTools\Traits;

use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use php7extension\yii\web\NotFoundHttpException;
use php7rails\domain\Domain;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Domain\Helpers\EntityHelper;

/**
 * Trait ArrayModifyTrait
 *
 * @package PhpLab\Core\Libs\ArrayTools\Traits
 *
 * @property string $id
 * @property string $primaryKey
 * @property Domain $domain
 */
trait ArrayModifyTrait
{

    abstract public function oneById($id, Query $query = null);

    abstract protected function getCollection();

    abstract protected function setCollection(Array $collection);

    public function insert(object $entity)
    {
        $collection = $this->getCollection();
        $collection[] = EntityHelper::toArray($entity);
        $this->setCollection($collection);
    }

    public function update(object $entity)
    {
        $id = EntityHelper::getAttribute($entity, $this->primaryKey);
        $entityBase = $this->oneById($id);
        $index = $this->getIndexOfEntity($entityBase);
        $collection = $this->getCollection();
        $collection[$index] = EntityHelper::toArray($entity);
        $this->setCollection($collection);
    }

    public function delete(object $entity)
    {
        $index = $this->getIndexOfEntity($entity);
        $collection = $this->getCollection();
        unset($collection[$index]);
        $this->setCollection($collection);
    }

    public function truncate()
    {
        $this->setCollection([]);
    }

    protected function getIndexOfEntity(object $entity)
    {
        $collection = $this->getCollection();
        $id = EntityHelper::getAttribute($entity, $this->primaryKey);
        foreach ($collection as $index => $data) {
            if (ArrayHelper::getValue($data, $this->primaryKey) == $id) {
                return $index;
            }
        }
        throw new NotFoundHttpException(__METHOD__ . ':' . __LINE__);
    }

}