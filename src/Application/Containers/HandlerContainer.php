<?php

namespace Milhojas\Application\Containers;


use Milhojas\Application\Command;
use Milhojas\Application\CommandHandler;
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