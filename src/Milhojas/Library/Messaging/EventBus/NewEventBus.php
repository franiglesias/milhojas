<?php

namespace Milhojas\Library\Messaging\EventBus;

class NewEventBus
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

    public function dispatch(Event $event)
    {
        $this->workers->work($event);
    }
}
