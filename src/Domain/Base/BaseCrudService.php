<?php

namespace PhpLab\Core\Domain\Base;

use PhpLab\Core\Domain\Interfaces\Entity\EntityIdInterface;
use PhpLab\Core\Domain\Libs\DataProvider;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Domain\Helpers\EntityHelper;
use PhpLab\Core\Domain\Helpers\ValidationHelper;
use PhpLab\Core\Domain\Interfaces\Repository\CrudRepositoryInterface;
use PhpLab\Core\Domain\Interfaces\Service\CrudServiceInterface;

/**
 * Class BaseCrudService
 * @package PhpLab\Core\Domain\Base
 *
 * @method CrudRepositoryInterface getRepository()
 */
abstract class BaseCrudService extends BaseService implements CrudServiceInterface
{

    public function beforeMethod($method)
    {
        return true;
    }

    protected function forgeQuery(Query $query = null)
    {
        $query = Query::forge($query);
        return $query;
    }

    public function getDataProvider(Query $query = null): DataProvider
    {
        $dataProvider = new DataProvider([
            'service' => $this,
            'query' => $query,
            //'page' => Yii::$app->request->get("page", 1),
            //'pageSize' => Yii::$app->request->get("per-page", 20),
        ]);
        return $dataProvider;
    }

    public function all(Query $query = null)
    {
        $isAvailable = $this->beforeMethod([$this, 'all']);
        $query = $this->forgeQuery($query);
        $collection = $this->getRepository()->all($query);
        return $collection;
    }

    public function count(Query $query = null): int
    {
        $isAvailable = $this->beforeMethod([$this, 'count']);
        $query = $this->forgeQuery($query);
        return $this->getRepository()->count($query);
    }

    public function oneById($id, Query $query = null)
    {
        $query = $this->forgeQuery($query);
        $isAvailable = $this->beforeMethod([$this, 'oneById']);
        return $this->getRepository()->oneById($id, $query);
    }

    public function create($data): EntityIdInterface
    {
        $isAvailable = $this->beforeMethod([$this, 'create']);
        $entityClass = $this->getEntityClass();
        $entity = new $entityClass;
        EntityHelper::setAttributes($entity, $data);
        ValidationHelper::validateEntity($entity);
        $this->getRepository()->create($entity);
        return $entity;
    }

    public function updateById($id, $data)
    {
        $isAvailable = $this->beforeMethod([$this, 'updateById']);
        $entityClass = $this->getEntityClass();
        $entityInstanse = new $entityClass;
        EntityHelper::setAttributes($entityInstanse, $data);
        ValidationHelper::validateEntity($entityInstanse);
        return $this->getRepository()->update($entityInstanse);
    }

    public function deleteById($id)
    {
        $isAvailable = $this->beforeMethod([$this, 'deleteById']);
        return $this->getRepository()->deleteById($id);
    }

}