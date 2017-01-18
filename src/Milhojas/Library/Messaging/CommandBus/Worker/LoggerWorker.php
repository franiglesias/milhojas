<?php

namespace Milhojas\Library\Messaging\CommandBus\Worker;

use Milhojas\Library\Messaging\CommandBus\Command;
use Psr\Log\LoggerInterface;

class LoggerWorker extends CommandWorker
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(Command $command)
    {
        $fqn = get_class($command);
        $parts = explode('\\', $fqn);
        $this->logger->notice(sprintf('Command %s has been launched.', end($parts)));
    }
}
