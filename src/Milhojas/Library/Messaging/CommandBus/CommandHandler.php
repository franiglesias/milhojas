<?php

namespace Milhojas\Library\Messaging\CommandBus;

interface CommandHandler
{
    public function handle(Command $command);
}
