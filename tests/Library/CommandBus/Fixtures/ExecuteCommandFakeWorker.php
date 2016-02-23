<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\Workers\CommandWorker;

use Tests\Library\CommandBus\Fixtures\SimpleCommandHandler;

/**
* A simple worker that executes a Command with the SimpleCommandHandler
*/
class ExecuteCommandFakeWorker implements CommandWorker
{
	public function __construct()
	{
	}
	
	public function setNext(CommandWorker $next)
	{
		$this->next = $next;
	}
	function execute(Command $command)
	{
		$handler = new SimpleCommandHandler();
		$handler->handle($command);
		$this->next->execute($command);
	}
}


?>