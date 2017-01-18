<?php

namespace Milhojas\Library\Messaging\CommandBus;

use Milhojas\Library\Messaging\Shared\Message;

/**
 * Represents an Imperative message to the system: DoSomething
 * Doesn't return data. Only throws exceptions.
 */
interface Command extends Message
{
}
