<?php

namespace Milhojas\Library\Messaging\CommandBus\Inflectors;
use Milhojas\Library\Messaging\CommandBus\Inflectors\Inflector;
use Milhojas\Library\Messaging\CommandBus\Command;

/**
* Description
*/
class SimpleInflector implements Inflector
{
	public function inflect(Command $command)
	{
		return preg_replace('/Command$/', '', get_class($command)).'Handler';
	}
}
?>
