<?php

namespace Milhojas\Library\Messaging\QueryBus;

use Milhojas\Library\Messaging\Shared\Loader\Loader;
use Milhojas\Library\Messaging\Shared\Inflector\Inflector;

/**
 * It is a mechanism to perform Queries, it returns answers to them.
 */
class SimpleQueryBus implements QueryBus
{
    /**
     * The class loader to load the Handlers.
     *
     * @var Loader
     */
    private $loader;
     /**
      * Strategy to compute the class handler.
      *
      * @var Inflector
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
     * Sends the query to the appropiate QueryHandler.
     *
     * @return mixed
     */
    public function execute(Query $query)
    {
        $handler = $this->getHandler($query);

        return $handler->answer($query);
    }
    /**
     * Computes and load the needed handler to perform the query.
     *
     * @param mixed $query
     */
    private function getHandler($query)
    {
        $handlerIdentifier = $this->inflector->inflect(get_class($query));

        return $this->loader->get($handlerIdentifier);
    }
}
