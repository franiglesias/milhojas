<?php

namespace Milhojas\Library\CommandBus\Inflectors;
use Milhojas\Library\CommandBus\Inflector;
use Milhojas\Library\CommandBus\Command;

/**
* Description
*/
class SimpleInflector implements Inflector
{
	public function inflect(Command $command)
	{
		return preg_replace('/Command/', '', get_class($command)).'Handler';
	}
}
?>