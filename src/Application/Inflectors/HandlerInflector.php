<?php

namespace Milhojas\Application\Inflectors;
use Milhojas\Application\Inflector;
use Milhojas\Application\Command;

/**
* Description
*/
class HandlerInflector implements Inflector
{
	public function inflect(Command $command)
	{
		$class = get_class($command);
		$class = substr($class, strrpos($class, '\\')+1);
		$class = preg_replace('/Command$/', '', $class);
		$handler = preg_replace('/(?<=.)[A-Z]/', '_$0', $class).'_handler';
		
		return strtolower($handler);
	}
}
?>