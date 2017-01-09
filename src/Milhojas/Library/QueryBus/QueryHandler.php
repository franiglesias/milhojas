<?php

namespace Milhojas\Library\QueryBus;

/**
 * A QueryHandler answer Queries passed to it
 * It should be constructed with all collaborator needed to compute the answer.
 */
interface QueryHandler
{
    /**
     * @param Query the $query to answer
     *
     * @return mixed the answer to the query
     */
    public function answer(Query $query);
}