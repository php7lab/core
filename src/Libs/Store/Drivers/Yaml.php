<?php

namespace PhpLab\Core\Libs\Store\Drivers;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;

class Yaml implements DriverInterface
{

    public function decode($content)
    {

        $data = SymfonyYaml::parse($content);
        //$data = ArrayHelper::toArray($data);
        return $data;
    }

    public function encode($data)
    {
        $content = Yaml::dump($data, 10);
        //$content = str_replace('    ', "\t", $content);
        return $content;
    }

}