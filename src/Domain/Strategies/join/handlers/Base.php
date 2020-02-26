<?php

namespace PhpLab\Core\Domain\Strategies\join\handlers;

use Illuminate\Support\Collection;
use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use PhpLab\Core\Domain\Dto\WithDto;
use PhpLab\Core\Helpers\PhpHelper;
use Symfony\Component\PropertyAccess\PropertyAccess;

abstract class Base
{

    protected static function getColumn($data, string $field)
    {

        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        if ($data instanceof Collection || is_array($data)) {
            $in = [];
            foreach ($data as $entity) {
                $value = $propertyAccessor->getValue($entity, $field);
                $in[] = $value;
            }
            // $in = EntityHelper::getColumn($data, $field);
            $in = array_unique($in);
            $in = array_values($in);
            return $in;
        } elseif (is_object($data)) {
            return $data->{$field};
        }
    }

    protected static function prepareValue($data, WithDto $w)
    {
        if (ArrayHelper::isIndexed($data)) {
            foreach ($data as &$item) {
                $item = self::prepareValue($item, $w);
            }
            return $data;
        }
        $value = ArrayHelper::getValue($w->relationConfig, 'foreign.value');
        if ($value) {
            /*if(is_callable($value)) {
                $data = call_user_func_array($value, [$data]);
            } else {
                $data = $value;
            }*/
            $data = PhpHelper::runValue($value, [$data]);
        }
        return $data;
    }
}