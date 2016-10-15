<?php

namespace Milhojas\Library\CommandBus\Containers;

use Milhojas\Library\CommandBus\Containers\Container;
/**
* Returns CommandHandlers
*/
class HandlerContainer implements Container
{
	private $container;
	
	public function __construct($container)
	{
		$this->container = $container;
	}
	
	public function make($command)
	{
		return $this->container->get($command);
	}
}

?>
