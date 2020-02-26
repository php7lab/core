<?php

namespace PhpLab\Core\Libs\Scenario\Base;

use PhpLab\Core\Libs\Scenario\Collections\ScenarioCollection;

abstract class BaseGroupScenario extends BaseScenario
{

    public $filters = [];

    public function run()
    {
        if (empty($this->filters)) {
            return;
        }
        $config = $this->getData();

        $filterCollection = new ScenarioCollection($this->filters);
        $config = $filterCollection->runAll($config);

        $this->setData($config);
    }

}
