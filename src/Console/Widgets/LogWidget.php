<?php

namespace PhpLab\Core\Console\Widgets;

use Symfony\Component\Console\Output\ConsoleOutputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LogWidget
{

    private $output;

    public function __construct(OutputInterface $output)
    {
        if ($output instanceof ConsoleOutputInterface) {
            $output = $output->getErrorOutput();
        }
        $this->output = $output;
    }

    public function start(string $message) {
        $this->output->write("<fg=white>{$message}... </>");
    }

    public function finishSuccess(string $message = 'OK') {
        $this->output->writeln("<fg=green>{$message}</>");
    }

    public function finishFail(string $message = 'FAIL') {
        $this->output->writeln("<fg=red>{$message}</>");
    }
}
