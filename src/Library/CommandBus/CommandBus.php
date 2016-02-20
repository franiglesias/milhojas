<?php

namespace Milhojas\Library\CommandBus;


/**
* Description
*/
class CommandBus
{
	private $container;
	private $inflector;

	function __construct(Container $container, Inflector $inflector)
	{
		$this->container = $container;
		$this->inflector = $inflector;
	}
	
	public function execute(Command $command)
	{
		$handler = $this->getHandler($command);
		$handler->handle($command);
	}
	
	protected function getHandler(Command $command)
	{
		$class = $this->inflector->inflect($command);
		return $this->container->make($class);
	}
}

?>