<?php

namespace Milhojas\Library\CommandBus\Containers;


use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;
use Milhojas\Application\Container;
/**
* Returns CommandHandlers
*/
class HandlerContainer implements Container
{
	private $container;
	
	function __construct($container)
	{
		$this->container = $container;
	}
	
	public function make($command)
	{
		return $this->container->get($command);
	}
}

?>