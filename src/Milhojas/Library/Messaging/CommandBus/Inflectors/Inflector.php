<?php

namespace Milhojas\Library\Messaging\CommandBus\Inflectors;

use Milhojas\Library\Messaging\CommandBus\Command;

interface Inflector
{
    public function inflect(Command $command);
}
