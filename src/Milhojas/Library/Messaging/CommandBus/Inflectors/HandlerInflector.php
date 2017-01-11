<?php

namespace Milhojas\Library\Messaging\CommandBus\Inflectors;
use Milhojas\Library\Messaging\CommandBus\Inflectors\Inflector;
use Milhojas\Library\Messaging\CommandBus\Command;

/**
* Description
*/
class HandlerInflector implements Inflector
{
	public function inflect(Command $command)
	{
		$parts = explode('\\', get_class($command));
		$class = end($parts);
		$handler = preg_replace(array('/Command$/', '/(?<=.)[A-Z]/'), array('', '_$0'), $class).'_handler';
		return strtolower($handler);
	}
}
?>
