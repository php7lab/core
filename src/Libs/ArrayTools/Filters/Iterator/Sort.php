<?php

namespace PhpLab\Core\Libs\ArrayTools\Filters\Iterator;

use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Libs\Scenario\Base\BaseScenario;

class Sort extends BaseScenario
{

    public $query;

    public function run()
    {
        $collection = $this->getData();
        $collection = $this->filterSort($collection, $this->query);
        $this->setData($collection);
    }

    protected function filterSort(Array $collection, Query $query)
    {
        $orders = $query->getParam('order');
        if (empty($orders)) {
            return $collection;
        }
        ArrayHelper::multisort($collection, array_keys($orders), array_values($orders));
        return $collection;
    }
}
