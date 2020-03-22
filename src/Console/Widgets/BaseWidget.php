<?php

namespace PhpLab\Core\Console\Widgets;

use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseWidget
{

    protected $output;

    public function __construct(OutputInterface $output)
    {
        if ($output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }
        $this->output = $output;
    }

}
