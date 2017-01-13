<?php

namespace Milhojas\Library\Messaging\CommandBus;

/**
 * A very Basic Command Bus that builds a chain of responsibility with an array of workers.
 */
class CommandBus
{
    protected $workers;

    public function __construct(array $workers)
    {
        $this->workers = $this->buildWorkersChain($workers);
    }

    /**
     * Builds the responsibility chain.
     *
     * @param string $workers
     *
     * @return array the chain
     *
     * @author Francisco Iglesias Gómez
     */
    protected function buildWorkersChain($workers)
    {
        $chain = array_shift($workers);
        while ($workers) {
            $chain->setNext(array_shift($workers));
        }

        return $chain;
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
        $this->workers->work($command);
    }
}
