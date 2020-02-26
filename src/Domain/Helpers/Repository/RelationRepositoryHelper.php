<?php

namespace PhpLab\Core\Domain\Helpers\Repository;

use Illuminate\Support\Collection;
use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use php7rails\domain\interfaces\services\ReadAllInterface;
use PhpLab\Core\Domain\Libs\Query;
use PhpLab\Core\Domain\Entities\relation\BaseForeignEntity;
//use PhpLab\Core\Domain\Enums\RelationClassTypeEnum;

class RelationRepositoryHelper
{

    public static function getAll(BaseForeignEntity $relationConfig, Query $query = null): Collection
    {
        $query = Query::forge($query);
        /** @var ReadAllInterface $repository */
        $repository = $relationConfig->model;
        //dd($query);
        //$repository = self::getInstance($relationConfig);
        return $repository->all($query);
    }

    /*private static function getInstance(BaseForeignEntity $relationConfigForeign): object
    {
        $domainInstance = \App::$domain->get($relationConfigForeign->domain);
        if ($relationConfigForeign->classType == RelationClassTypeEnum::SERVICE) {
            $locator = $domainInstance;
        } else {
            $locator = $domainInstance->repositories;
        }
        return ArrayHelper::getValue($locator, $relationConfigForeign->name);
    }*/

}
