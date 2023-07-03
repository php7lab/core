<?php

namespace PhpLab\Core\Domain\Strategies\join;

use Illuminate\Support\Collection;
use PhpLab\Core\Domain\Dto\WithDto;
use PhpLab\Core\Domain\Entities\relation\RelationEntity;
use PhpLab\Core\Domain\Enums\RelationEnum;
use PhpLab\Core\Domain\Strategies\join\handlers\Callback;
use PhpLab\Core\Domain\Strategies\join\handlers\HandlerInterface;
use PhpLab\Core\Domain\Strategies\join\handlers\Many;
use PhpLab\Core\Domain\Strategies\join\handlers\ManyToMany;
use PhpLab\Core\Domain\Strategies\join\handlers\One;
use PhpLab\Core\Patterns\Strategy\Base\BaseStrategyContextHandlers;

/**
 * Class PaymentStrategy
 *
 * @package PhpLab\Core\Domain\Strategies\payment
 *
 * @property-read HandlerInterface $strategyInstance
 */
class JoinStrategy extends BaseStrategyContextHandlers
{

    public function getStrategyDefinitions()
    {
        return [
            RelationEnum::ONE => One::class,
            RelationEnum::MANY => Many::class,
            RelationEnum::MANY_TO_MANY => ManyToMany::class,
            RelationEnum::CALLBACK => Callback::class,
        ];
    }

    public function load($entity, WithDto $w, $relCollection): RelationEntity
    {
        return $this->getStrategyInstance()->load($entity, $w, $relCollection);
    }

    public function join(Collection $collection, RelationEntity $relationEntity)
    {
        if (empty($collection)) {
            return null;
        }
        return $this->getStrategyInstance()->join($collection, $relationEntity);
    }

}