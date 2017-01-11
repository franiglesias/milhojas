<?php

namespace Milhojas\Library\Messaging\CommandBus\Workers;

use Milhojas\Library\Messaging\Shared\Loader\Loader;
use Milhojas\Library\Messaging\Shared\Inflector\Inflector;
use Milhojas\Library\Messaging\CommandBus\Command;

/**
 * Manages the execution of a command with the right command handler
 * You can control behavior using different inflectors.
 */
class ExecuteWorker extends CommandWorker
{
    /**
     * Loads the handler given a key derived by INflector from Command.
     *
     * @var Loader
     */
    private $loader;
    /**
     * Guess the key to load the Handler.
     *
     * @var mixed
     */
    private $inflector;

    /**
     * @param Loader    $loader
     * @param Inflector $inflector
     */
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
