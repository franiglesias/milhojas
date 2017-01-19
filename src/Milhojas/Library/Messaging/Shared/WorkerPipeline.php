<?php

namespace Milhojas\Library\Messaging\Shared;

class WorkerPipeline
{
    private $pipeline;

    public function __construct(array $workers)
    {
        $this->pipeline = $this->build($workers);
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
    protected function build($workers)
    {
        $chain = array_shift($workers);
        while ($workers) {
            $chain->chain(array_shift($workers));
        }

        return $chain;
    }

    public function work(Message $message)
    {
        return $this->pipeline->work($message);
    }
}
