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
        $content = json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        $content = str_replace('    ', "\t", $content);
        return $content;
    }

}