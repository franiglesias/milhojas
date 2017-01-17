<?php

namespace Milhojas\Library\Messaging\Command\Worker;

use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\Worker\CommandWorker;
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
