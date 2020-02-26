<?php

namespace PhpLab\Core\Helpers\Types;

use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use php7rails\domain\data\EntityCollection;
use php7rails\domain\values\BaseValue;
use PhpLab\Core\Exceptions\InvalidArgumentException;
use PhpLab\Core\Helpers\Helper;
use PhpLab\Core\Libs\ArrayTools\Helpers\Collection;

class ObjectType extends BaseType
{

    protected function _isValid($value, $config = null)
    {
        if ($value === null) {
            return true;
        }
        $class = $config['type'];
        if (is_object($value)) {
            self::validateObject($config, $value);
        } else {
            $isEntityClassName = ! is_subclass_of($class, \Illuminate\Support\Collection::class);

            if ($isEntityClassName) {
                if ( ! is_array($value)) {
                    throw new InvalidArgumentException('Entity data not array or object!');
                }
                self::validateCollection($config, $value);
            }
        }
        return true;
    }

    public function normalizeValue($value, $config = null)
    {
        if (is_object($value)) {
            return $value;
        }
        $class = $config['type'];
        if (is_subclass_of($class, BaseValue::class)) {
            /** @var BaseValue $valueObject */
            $valueObject = new $class;
            $valueObject->set($value);
            return $valueObject;
        }
        $isEntityClassName = ! is_subclass_of($class, \Illuminate\Support\Collection::class);
        if ($isEntityClassName) {
            $isCollection = ! empty($config['isCollection']);
            if ($isCollection) {
                return new EntityCollection($class, $value);
            } else {
                return Helper::forgeEntity($value, $class);
            }
        }
        return null;
    }

    private static function validateObject($config, $value)
    {
        $class = $config['type'];
        $isCollection = ! empty($config['isCollection']);
        if ($value instanceof Collection && ! $isCollection) {
            throw new InvalidArgumentException('Value can not be collection');
        }
        if ($isCollection && ! $value instanceof Collection) {
            throw new InvalidArgumentException('Need collection');
        }
        if ( ! $value instanceof $class) {
            throw new InvalidArgumentException('Object not instance of class');
        }
    }

    private static function validateCollection($config, $value)
    {
        if (empty($value)) {
            return;
        }
        $isCollection = ! empty($config['isCollection']);
        $isIndexed = ArrayHelper::isIndexed($value);
        if ($isCollection && ! $isIndexed) {
            throw new InvalidArgumentException('Need array of items for collection');
        }
        if ( ! $isCollection && $isIndexed) {
            throw new InvalidArgumentException('Need array of item for entity');
        }
    }

}