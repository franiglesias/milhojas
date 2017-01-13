<?php

namespace Milhojas\Infrastructure\Process;

use Symfony\Component\Process\Process;

/**
 * Process decorator/adapter.
 */
class CommandLineProcess implements CommandLine
{
    private $process;

    public function __construct($line)
    {
        $this->process = new Process($line);

        return $this;
    }

    public function setWorkingDirectory($directory)
    {
        $this->process->setWorkingDirectory($directory);

        return $this;
    }

    public function start(callable $callable = null)
    {
        $this->process->mustRun($callable);

        return $this;
    }
}
