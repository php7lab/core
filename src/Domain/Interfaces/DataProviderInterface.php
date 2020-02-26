<?php

namespace PhpLab\Core\Domain\Interfaces;

use PhpLab\Core\Domain\Libs\DataProvider;
use PhpLab\Core\Domain\Libs\Query;

interface DataProviderInterface
{

    public function getDataProvider(Query $query = null): DataProvider;

}