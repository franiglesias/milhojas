<?php

namespace Milhojas\Library\Messaging\CommandBus;

use Milhojas\Library\Messaging\Shared\Pipeline\Pipeline;

/**
 * A very Basic Command Bus that builds a chain of responsibility with an array of pipeline.
 */
class CommandBus
{
    protected $pipeline;

    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    /**
     * Execute command.
     *
     * @param Command $command
     *
     * @author Fran Iglesias
     */
    public function execute(Command $command)
    {
        $this->pipeline->work($command);
    }
}
