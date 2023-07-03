<?php

namespace PhpLab\Core\Libs\Scenario\Collections;

use php7rails\domain\values\BaseValue;
use PhpLab\Core\Helpers\ClassHelper;
use PhpLab\Core\Helpers\Helper;
use PhpLab\Core\Libs\ArrayTools\Helpers\Collection;
use PhpLab\Core\Libs\Scenario\Base\BaseScenario;
use PhpLab\Core\Libs\Scenario\Exceptions\StopException;

class ScenarioCollection extends Collection
{

    public $event;

    protected function loadItems($items)
    {
        $items = $this->filterItems($items);
        return parent::loadItems($items);
    }

    private function filterItems($items)
    {
        $result = [];
        foreach ($items as $definition) {
            $definition = Helper::isEnabledComponent($definition);
            if ($definition) {
                $filterInstance = ClassHelper::createObject($definition, [], BaseScenario::class);
                if ($filterInstance->isEnabled()) {
                    $result[] = $filterInstance;
                }
            }
        }
        return $result;
    }

    public function runIs($data = null, object $event = null)
    {
        try {
            $this->runAll($data, $event);
            return true;
        } catch (StopException $e) {
            return false;
        }
    }

    /**
     * @param            $data
     * @param object $event
     *
     * @return BaseValue
     */
    public function runAll($data = null, object $event = null)
    {
        /** @var BaseScenario[] $filterCollection */
        $filterCollection = $this->all();
        if (empty($filterCollection)) {
            return $data;
        }
        $event = ! empty($event) ? $event : $this->event;
        foreach ($filterCollection as $filterInstance) {
            $data = $this->runOne($filterInstance, $data, $event);
        }
        return $data;
    }

    public function runOne(BaseScenario $filterInstance, $data = null, BaseObject $event = null)
    {
        $filterInstance->setData($data);
        $filterInstance->event = $event;
        $filterInstance->run();
        $data = $filterInstance->getData();
        return $data;
    }

}
