<?php

namespace Tests\Library\Messaging\CommandBus\Fixtures;

use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\Worker\CommandWorker;

use Tests\Library\Messaging\CommandBus\Fixtures\SimpleCommandHandler;

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
