<?php

namespace PhpLab\Core\Libs\Store\Drivers;

interface DriverInterface
{

    public function decode($content);

    public function encode($data);

}