<?php

namespace Milhojas\Library\QueryBus;

use Milhojas\Library\QueryBus\Loader\Loader;

/**
 * It is a mechanism to perform Queries, it returns answers to them.
 */
class SimpleQueryBus implements QueryBus
{
    private $handlers;
    private $loader;

    public function __construct(Loader $loader)
    {
        $this->loader = $loader;
    }

    /**
     * Sends the query to the appropiate QueryHandler.
     *
     * @return mixed
     */
    public function execute(Query $query)
    {
        $handler = $this->getHandler($query);

        return $handler->answer($query);
    }

    private function getHandler($query)
    {
        return $this->loader->get($query);
    }
}
