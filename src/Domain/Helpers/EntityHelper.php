<?php

namespace PhpLab\Core\Domain\Helpers;

use Illuminate\Support\Collection;
use PhpLab\Core\Helpers\InstanceHelper;
use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use PhpLab\Core\Legacy\Yii\Helpers\Inflector;
use PhpLab\Core\Domain\Exceptions\UnprocessibleEntityException;
use PhpLab\Core\Domain\Interfaces\Entity\ValidateEntityInterface;
use ReflectionClass;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class EntityHelper
{

    public static function createEntity(string $entityClass, $attributes = [])
    {
        $entityInstance = new $entityClass;
        if ($attributes) {
            self::setAttributes($entityInstance, $attributes);
        }
        return $entityInstance;
    }

    public static function isEntity($data)
    {
        return is_object($data) && ! ($data instanceof Collection);
    }

    public static function indexingCollection(Collection $collection, string $fieldName): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $array = [];
        foreach ($collection as $item) {
            $pkValue = $propertyAccessor->getValue($item, $fieldName);
            $array[$pkValue] = $item;
        }
        return $array;
    }

    public static function createEntityCollection(string $entityClass, array $data = []): Collection
    {
        $collection = new Collection;
        foreach ($data as $item) {
            $entity = new $entityClass;
            self::setAttributes($entity, $item);
            $collection->add($entity);
        }
        return $collection;
    }

    public static function toArrayForTablize(object $entity, array $columnList = []): array
    {
        $array = self::toArray($entity);
        $arraySnakeCase = [];
        foreach ($array as $name => $value) {
            $tableizeName = Inflector::underscore($name);
            $arraySnakeCase[$tableizeName] = $value;
        }
        if ($columnList) {
            $arraySnakeCase = ArrayHelper::extractByKeys($arraySnakeCase, $columnList);
        }
        return $arraySnakeCase;
    }

    public static function collectionToArray(\Illuminate\Support\Collection $collection): array
    {
        $serializer = new Serializer([new ObjectNormalizer()]);
        $normalizeHandler = function ($value) use ($serializer) {
            return $serializer->normalize($value);
            //return is_object($value) ? EntityHelper::toArray($value) : $value;
        };
        $normalizeCollection = $collection->map($normalizeHandler);
        return $normalizeCollection->all();
    }

    public static function toArray($entity): array
    {
        $array = [];
        if(is_array($entity)) {
            $array = $entity;
        } elseif ($entity instanceof Collection) {
            $array = $entity->toArray();
        } elseif (is_object($entity)) {
            $attributes = self::getAttributeNames($entity);
            $propertyAccessor = PropertyAccess::createPropertyAccessor();
            foreach ($attributes as $attribute) {
                $array[$attribute] = $propertyAccessor->getValue($entity, $attribute);
            }
        }
        return $array;
    }

    public static function getAttributeNames(object $entity): array
    {
        $reflClass = new ReflectionClass($entity);
        $attributesRef = $reflClass->getProperties();
        return ArrayHelper::getColumn($attributesRef, 'name');
        /*$attributes = [];
        foreach ($attributesRef as $reflectionProperty) {
            $attributes[] = $reflectionProperty->;
        }
        return $attributes;*/
    }

    public static function setAttribute(object $entity, string $name, $value): void
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $propertyAccessor->setValue($entity, $name, $value);
    }

    public static function setAttributes(object $entity, $data): void
    {
        if (empty($data)) {
            return;
        }
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($data as $name => $value) {
            $propertyAccessor->setValue($entity, $name, $value);
        }
    }

    /*public static function createEntity(strung $entityClass, array $data = [])
    {
        $entity = new $entityClass;
        self::setAttributes($entity, $data);
        return $entity;
    }*/

    /*public static function getColumn(\Illuminate\Support\Collection $collection, string $columnName) : array {
        $tableArray = self::collectionToArray($tableCollection);
        $tableNameArray = ArrayHelper::getColumn($tableArray, $columnName);
        return $tableNameArray;
    }*/

    public static function getAttribute(object $entity, string $key): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        return $propertyAccessor->getValue($entity, $key);
    }

    public static function getColumn(Collection $collection, string $key): array
    {
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        $array = [];
        foreach ($collection as $entity) {
            $array[] = $propertyAccessor->getValue($entity, $key);
        }
        $array = array_values($array);
        return $array;
    }

    /*public static function getValue($array, $key, $default = null)
    {
        if ($key instanceof \Closure) {
            return $key($array, $default);
        }

        if (is_array($key)) {
            $lastKey = array_pop($key);
            foreach ($key as $keyPart) {
                $array = static::getValue($array, $keyPart);
            }
            $key = $lastKey;
        }

        if (is_array($array) && (isset($array[$key]) || array_key_exists($key, $array))) {
            return $array[$key];
        }

        if (($pos = strrpos($key, '.')) !== false) {
            $array = static::getValue($array, substr($key, 0, $pos), $default);
            $key = substr($key, $pos + 1);
        }

        if (is_object($array)) {
            // this is expected to fail if the property does not exist, or __get() is not implemented
            // it is not reliably possible to check whether a property is accessible beforehand
            return $array->$key;
        } elseif (is_array($array)) {
            return (isset($array[$key]) || array_key_exists($key, $array)) ? $array[$key] : $default;
        }

        return $default;
    }*/

}