<?php

namespace Tests\Library\Messaging\CommandBus\Fixtures;

use Milhojas\Library\Messaging\CommandBus\Workers\CommandWorker;
use Milhojas\Library\Messaging\CommandBus\Command;

use Tests\Library\Messaging\CommandBus\Fixtures\SimpleCommandHandler;

/**
* A simple worker that does not execute the command. It only registers itself in the test spy
*/
class IntactCommandFakeWorker extends FakeCommandWorker
{
	
	function execute(Command $command)
	{
		$this->spy->registerExecution($this, $command);
		
		$this->spy->registerWorker($this);
		$this->delegateNext($command);
	}
}


?>
