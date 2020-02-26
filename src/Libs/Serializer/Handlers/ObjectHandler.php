<?php

namespace PhpLab\Core\Libs\Serializer\Handlers;

use PhpLab\Core\Libs\Serializer\ArraySerializer;

class ObjectHandler implements SerializerHandlerInterface
{

    public $properties = [];
    public $recursive = true;

    /** @var ArraySerializer */
    public $parent;

    public function encode($object)
    {
        if (is_object($object)) {
            $object = $this->objectHandle($object);
        }
        return $object;
    }

    protected function objectHandle(object $object): array
    {
        if ( ! empty($this->properties)) {
            $className = get_class($object);
            if ( ! empty($this->properties[$className])) {
                $result = [];
                foreach ($this->properties[$className] as $key => $name) {
                    if (is_int($key)) {
                        $result[$name] = $object->$name;
                    } else {
                        //$result[$key] = ArrayHelper::getValue($object, $name);
                        $result[$key] = $object->$name;
                    }
                }

                return $this->recursive ? $this->parent->toArray($result) : $result;
            }
        }
        if (method_exists($object, 'toArray')) { // if ($object instanceof Arrayable) {

            $result = $object->toArray([], []);
        } else {
            $result = [];

            foreach ($object as $key => $value) {
                $result[$key] = $value;
            }
        }

        return $this->recursive ? $this->parent->toArray($result) : $result;
    }
}