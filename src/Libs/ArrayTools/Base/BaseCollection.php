<?php

namespace PhpLab\Core\Libs\ArrayTools\Base;

use ArrayAccess;
use Countable;
use Iterator;
use PhpLab\Core\Legacy\Yii\Helpers\ArrayHelper;
use Serializable;

abstract class BaseCollection implements ArrayAccess, Countable, Iterator, Serializable
{

    private $items = [];
    private $position = 0;

    public function __construct($items = null)
    {
        $this->loadItems($items);
    }

    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    public function offsetGet($offset)
    {
        return $this->offsetExists($offset) ? $this->items[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function current()
    {
        return $this->items[$this->position];
    }

    public function key()
    {
        return $this->position;
    }

    public function next()
    {
        ++$this->position;
    }

    public function valid()
    {
        return isset($this->items[$this->position]);
    }

    public function count()
    {
        return count($this->items);
    }

    public function serialize()
    {
        return serialize($this->items);
    }

    public function unserialize($data)
    {
        $this->items = unserialize($data);
    }

    public function __invoke(array $data = null)
    {
        if (is_null($data)) {
            return $this->items;
        } else {
            $this->loadItems($data);
        }
        return null;
    }

    public function all()
    {
        return $this->items;
    }

    public function fields()
    {

    }

    public function extraFields()
    {

    }

    public function toArray(array $fields = [], array $expand = [], $recursive = true)
    {
        return ArrayHelper::toArray($this->items, $fields, $recursive);
    }

    protected function loadItems($items)
    {
        if (empty($items)) {
            return;
        }
        $this->items = $this->itemsToArray($items);
        $this->rewind();
    }

    protected function itemsToArray($items)
    {
        if (empty($items)) {
            return null;
        }
        if (is_object($items)) {
            if ($items instanceof BaseCollection) {
                $items = $items->all();
            } else {
                throw new \InvalidArgumentException('Collection data can not be object');
            }
        }
        return $items;
    }
}
