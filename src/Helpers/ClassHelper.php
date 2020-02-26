<?php

namespace PhpLab\Core\Helpers;

use Exception;
use php7extension\yii\web\ServerErrorHttpException;
use PhpLab\Core\Exceptions\InvalidArgumentException;
use PhpLab\Core\Exceptions\InvalidConfigException;

class ClassHelper
{

    public static function normalizeClassName($className)
    {
        $className = trim($className, '@/\\');
        $className = str_replace('/', '\\', $className);
        return $className;
    }

    public static function isInstanceOf($instance, $interface)
    {
        if (empty($instance)) {
            throw new InvalidArgumentException("Argument \"instance\" is empty");
        }
        if (empty($interface)) {
            throw new InvalidArgumentException("Argument \"interfaceClass\" is empty");
        }
        if ( ! is_object($instance)) {
            throw new InvalidArgumentException("Class \"$instance\" not exists");
        }
        if ( ! interface_exists($interface) && ! class_exists($interface)) {
            throw new InvalidArgumentException("Class \"$interface\" not exists");
        }
        if ( ! $instance instanceof $interface) {
            $instanceClassName = get_class($instance);
            throw new Exception("Class \"$instanceClassName\" not instanceof \"$interface\"");
        }
    }

    public static function getInstanceOfClassName($class, $classname)
    {
        $class = self::getClassName($class, $classname);
        if (empty($class)) {
            return null;
        }
        if (class_exists($class)) {
            return new $class();
        }
        return null;
    }

    public static function getNamespaceOfClassName($class)
    {
        $lastSlash = strrpos($class, '\\');
        return substr($class, 0, $lastSlash);
    }

    public static function getClassOfClassName($class)
    {
        $lastPos = strrpos($class, '\\');
        $name = substr($class, $lastPos + 1);
        return $name;
    }

    public static function extractNameFromClass($class, $type)
    {
        $lastPos = strrpos($class, '\\');
        $name = substr($class, $lastPos + 1, 0 - strlen($type));
        return $name;
    }

    public static function createObject($definition, array $params = [], $interface = null)
    {
        if (empty($definition)) {
            throw new InvalidConfigException('Empty class config');
        }
        $definition = self::normalizeComponentConfig($definition);
        $object = new $definition['class'];
        self::configure($object, $params);
        self::configure($object, $definition);
        if ( ! empty($interface)) {
            self::isInstanceOf($object, $interface);
        }
        return $object;
    }

    public static function configure($object, $properties)
    {
        if (empty($properties)) {
            return $object;
        }
        foreach ($properties as $name => $value) {
            if ($name != 'class') {
                $object->{$name} = $value;
            }
        }
        return $object;
    }

    static function getClassName($className, $namespace)
    {
        if (empty($namespace)) {
            return $className;
        }
        if ( ! ClassHelper::isClass($className)) {
            $className = $namespace . '\\' . ucfirst($className);
        }
        return $className;
    }

    public static function getNamespace($name)
    {
        $name = trim($name, '\\');
        $arr = explode('\\', $name);
        array_pop($arr);
        $name = implode('\\', $arr);
        return $name;
    }

    static function normalizeComponentListConfig($config)
    {
        if (empty($config)) {
            return [];
        }
        $components = [];
        foreach ($config as $id => &$definition) {
            $definition = self::normalizeComponentConfig($definition);
            if (self::isComponent($id, $definition)) {
                $components[$id] = $definition;
            }
        }
        return $components;
    }

    static function isComponent($id, $definition)
    {
        if (empty($definition)) {
            return false;
        }
        return PhpHelper::isValidName($id) && array_key_exists('class', $definition);
    }

    static function normalizeComponentConfig($config, $class = null)
    {
        if (empty($config) && empty($class)) {
            return $config;
        }
        if ( ! empty($class)) {
            $config['class'] = $class;
        }
        if (is_array($config)) {
            return $config;
        }
        if (self::isClass($config)) {
            $config = ['class' => $config];
        }
        return $config;
    }

    static function isClass($name)
    {
        return is_string($name) && strpos($name, '\\') !== false;
    }


}