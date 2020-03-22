<?php

namespace PhpLab\Core\Console\Widgets;

class LogWidget extends BaseWidget
{

    public function start(string $message)
    {
        $this->output->write("<fg=white>{$message}... </>");
    }

    public function finishSuccess(string $message = 'OK')
    {
        $this->output->writeln("<fg=green>{$message}</>");
    }

    public function finishFail(string $message = 'FAIL')
    {
        $this->output->writeln("<fg=red>{$message}</>");
    }
}
