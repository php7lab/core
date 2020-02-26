<?php

namespace PhpLab\Core\Libs\Serializer;

use PhpLab\Core\Libs\Serializer\Handlers\ArrayHandler;
use PhpLab\Core\Libs\Serializer\Handlers\ObjectHandler;

class ArraySerializer
{

    public $properties = [];
    public $recursive = true;
    public $handlers = [
        ArrayHandler::class,
        ObjectHandler::class,
    ];
    protected $handlerInstances = [];

    public function setHandlerClasses(array $handlers)
    {
        foreach ($handlers as $handler) {
            $this->setHandlerClass($handler);
        }
    }

    public function setHandlerClass($handler)
    {
        $instance = new $handler;
        $instance->properties = $this->properties;
        $instance->recursive = $this->recursive;
        $instance->parent = $this;
        $this->handlerInstances[] = $instance;
    }

    public function __construct($handlers = null)
    {
        $handlers = $handlers ?? $this->handlers;
        $this->setHandlerClasses($handlers);
    }

    public function toArray($object)
    {
        foreach ($this->handlerInstances as $handler) {
            $object = $handler->encode($object);
        }
        return $object;
    }

}