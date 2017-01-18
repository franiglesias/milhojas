<?php

namespace Milhojas\Library\Messaging\QueryBus;

/**
 * It is a mechanism to perform Queries, it returns answers to them.
 */
class QueryBus
{
    private $workers;
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
            $chain->chain(array_shift($workers));
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
    public function execute(Query $query)
    {
        return $this->workers->work($query);
    }
}
