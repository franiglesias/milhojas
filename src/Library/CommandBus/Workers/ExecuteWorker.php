<?php

namespace Milhojas\Library\CommandBus\Workers;

use Milhojas\Library\CommandBus\Containers\Container;
use Milhojas\Library\CommandBus\Inflectors\Inflector;
use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\Workers\CommandWorker;

/**
* Manages the execution of a command with the right command handler
* You can control de behavior using different inflectors
*/

class ExecuteWorker extends CommandWorker
{
	private $container;
	private $inflector;
	
	public function __construct(Container $container, Inflector $inflector)
	{
		$this->container = $container;
		$this->inflector = $inflector;
	}
	
	public function execute(Command $command)
	{
		$handler = $this->getHandler($command);
		$handler->handle($command);
		$this->delegateNext($command);
	}
	
	protected function getHandler(Command $command)
	{
		$class = $this->inflector->inflect($command);
		return $this->container->make($class);
	}
}

?>
