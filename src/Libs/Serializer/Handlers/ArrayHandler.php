<?php

namespace PhpLab\Core\Libs\Serializer\Handlers;

use PhpLab\Core\Libs\Serializer\ArraySerializer;

class ArrayHandler implements SerializerHandlerInterface
{

    public $properties = [];
    public $recursive = true;

    /** @var ArraySerializer */
    public $parent;

    public function encode($object)
    {
        if (is_array($object)) {
            $object = $this->arrayHandle($object);
        }
        return $object;
    }

    protected function arrayHandle(array $object): array
    {
        if ($this->recursive) {
            foreach ($object as $key => $value) {
                if (is_array($value) || is_object($value)) {
                    $object[$key] = $this->parent->toArray($value);
                }
            }
        }
        return $object;
    }
}