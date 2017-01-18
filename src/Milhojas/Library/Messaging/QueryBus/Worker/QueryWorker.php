<?php

namespace Milhojas\Library\Messaging\QueryBus\Worker;

use Milhojas\Library\Messaging\QueryBus\Query;
use Milhojas\Library\Messaging\Shared\Message;
use Milhojas\Library\Messaging\Shared\Worker\MessageWorker;
use Milhojas\Library\Messaging\Shared\Loader\Loader;
use Milhojas\Library\Messaging\Shared\Inflector\Inflector;

class QueryWorker extends MessageWorker
{
    /**
     * @var Loader Strategy to load classes
     */
    private $loader;
    /**
     * @var Inflector Strategy to inflect handlers names
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
     * {@inheritdoc}
     */
    public function execute(Message $query)
    {
        $handler = $this->getHandler($query);

        return $handler->answer($query);
    }

    public function getHandler(Query $query)
    {
        $service = $this->inflector->inflect(get_class($query));

        return $this->loader->get($service);
    }
}
