<?php

namespace PhpLab\Core\Domain\Libs;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Entities\DataProviderEntity;
use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use PhpLab\Core\Domain\Interfaces\ReadAllInterface;

class DataProvider
{

    /** @var ReadAllInterface */
    private $service;

    /** @var Query */
    private $query;

    /** @var DataProviderEntity */
    private $entity;

    public function __construct(array $config)
    {
        $this->service = ArrayHelper::getValue($config, 'service');
        $this->query = ArrayHelper::getValue($config, 'query', Query::forge());

        $this->entity = new DataProviderEntity;
        $this->entity->setPage(intval(ArrayHelper::getValue($config, 'page', 1)));
        $this->entity->setPageSize(intval(ArrayHelper::getValue($config, 'pageSize', 10)));
        $this->entity->setMaxPageSize(intval(ArrayHelper::getValue($config, 'maxPageSize', 50)));
    }

    public function getAll(): DataProviderEntity
    {
        $this->entity->setTotalCount($this->getTotalCount());
        $this->entity->setCollection($this->getCollection());
        return $this->entity;
    }

    private function getCollection(): Collection
    {
        if ($this->entity->getCollection() === null) {
            $query = clone $this->query;
            $query->limit($this->entity->getPageSize());
            $query->offset($this->entity->getPageSize() * ($this->entity->getPage() - 1));
            $this->entity->setCollection($this->service->all($query));
        }
        return $this->entity->getCollection();
    }

    private function getTotalCount(): int
    {
        if ( $this->entity->getTotalCount() === null) {
            $query = clone $this->query;
            $query->removeParam(Query::PER_PAGE);
            $query->removeParam(Query::LIMIT);
            $query->removeParam(Query::ORDER);
            $this->entity->setTotalCount($this->service->count($query));
        }
        return $this->entity->getTotalCount();
    }

}