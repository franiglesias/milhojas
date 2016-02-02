<?php

namespace Milhojas\Application\Inflectors;
use Milhojas\Application\Inflector;
use Milhojas\Application\Command;

/**
* Description
*/
class SimpleInflector implements Inflector
{
	public function inflect(Command $command)
	{
		$name = get_class($command).'Handler';
		return $name;
	}
}
?>