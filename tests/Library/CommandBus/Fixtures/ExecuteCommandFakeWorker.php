<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\Workers\CommandWorker;

use Tests\Library\CommandBus\Fixtures\SimpleCommandHandler;

/**
* A simple worker that executes a Command with the SimpleCommandHandler
*/
class ExecuteCommandFakeWorker extends FakeCommandWorker
{
	
	function execute(Command $command)
	{
		$this->spy->registerExecution($this, $command);
		$this->spy->registerWorker($this);
		$handler = new SimpleCommandHandler();
		$handler->handle($command);
		$this->delegateNext($command);
	}
}


?>