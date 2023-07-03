<?php

namespace PhpLab\Core\Patterns\Strategy\Base;

/**
 * Class BaseStrategyContext
 *
 * @package PhpLab\Core\Libs\Scenario\Base
 *
 * @property-read Object $strategyInstance
 */
abstract class BaseStrategyContext
{

    private $strategyInstance;

    public function __construct(object $strategyInstance = null)
    {
        $this->strategyInstance = $strategyInstance;
    }

    protected function getStrategyInstance()
    {
        return $this->strategyInstance;
    }

    protected function setStrategyInstance($strategyInstance)
    {
        $this->strategyInstance = $strategyInstance;
    }

}
