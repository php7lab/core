<?php

namespace PhpLab\Core\Libs\ArrayTools\Helpers;

use PhpLab\Core\Helpers\ClassHelper;
use PhpLab\Core\Libs\ArrayTools\Base\BaseCollection;

class Collection extends BaseCollection
{

    public static function forge($items = null)
    {
        $collection = ClassHelper::createObject(static::class);
        $collection->load($items);
        return $collection;
    }

    public static function createInstance($items)
    {
        return new static($items);
    }

    public function keys()
    {
        return array_keys($this->all());
    }

    public function values()
    {
        return array_values($this->all());
    }

    public function first()
    {
        if ($this->count() == 0) {
            return null;
        }
        return $this->offsetGet(0);
    }

    public function last()
    {
        if ($this->count() == 0) {
            return null;
        }
        $lastIndex = $this->count() - 1;
        return $this->offsetGet($lastIndex);
    }

    public function fetch()
    {
        if ( ! $this->valid()) {
            return false;
        }
        $item = $this->current();
        $this->next();
        return $item;
    }

    public function load($items)
    {
        $this->loadItems($items);
    }

}
