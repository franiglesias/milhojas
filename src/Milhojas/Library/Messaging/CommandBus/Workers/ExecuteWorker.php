<?php

namespace Milhojas\Library\Messaging\CommandBus\Workers;

use Milhojas\Library\Messaging\Shared\Loader\Loader;
use Milhojas\Library\Messaging\Shared\Inflector\Inflector;
use Milhojas\Library\Messaging\CommandBus\Command;

/**
 * Manages the execution of a command with the right command handler
 * You can control de behavior using different inflectors.
 */
class ExecuteWorker extends CommandWorker
{
    private $loader;
    private $inflector;

    public function __construct(Loader $loader, Inflector $inflector)
    {
        $this->loader = $loader;
        $this->inflector = $inflector;
    }

    /**
     * Execute the needed handler and pass the comnand to the next Worker.
     *
     * @param Command $command
     */
    public function execute(Command $command)
    {
        $handler = $this->getHandler($command);
        $handler->handle($command);
        $this->delegateNext($command);
    }

    /**
     * Resolves the handler for this commnad.
     *
     * @param Command $command
     */
    protected function getHandler(Command $command)
    {
        $handler = $this->inflector->inflect(get_class($command));

        return $this->loader->get($handler);
    }
}
