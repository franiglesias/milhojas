<?php

namespace Milhojas\Application\Cantine\Command;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

class RegisterStudentAsCantineUserHandler implements CommandHandler
{
    /**
     * {@inheritdoc}
     */
    public function handle(Command $command)
    {
        throw new \LogicException('Not implemented'); // TODO
    }
}
