<?php

namespace Milhojas\Library\Messaging\QueryBus;

use Milhojas\Library\Messaging\Shared\Pipeline\Pipeline;

/**
 * It is a mechanism to perform Queries, it returns answers to them.
 */
class QueryBus
{
    private $pipeline;

    public function __construct(Pipeline $pipeline)
    {
        $this->pipeline = $pipeline;
    }

    /**
     * Execute command.
     *
     * @param Query $query
     *
     * @author Fran Iglesias
     */
    public function execute(Query $query)
    {
        return $this->pipeline->work($query);
    }
}
