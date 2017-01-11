<?php

namespace Milhojas\Library\Messaging\CommandBus;

/**
 * A very Basic Command Bus that builds a chain of responsibility with an array of workers.
 */
class BasicCommandBus implements CommandBus
{
    protected $workersChain;

    public function __construct(array $workers)
    {
        $this->workersChain = $this->buildWorkersChain($workers);
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
        $chain = array_pop($workers);
        while (count($workers) > 0) {
            $prev = array_pop($workers);
            $prev->setNext($chain);
            $chain = $prev;
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
        $this->workersChain->execute($command);
    }
}
