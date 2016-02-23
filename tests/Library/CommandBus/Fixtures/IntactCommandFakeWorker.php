<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\Workers\CommandWorker;
use Milhojas\Library\CommandBus\Command;

use Tests\Library\CommandBus\Fixtures\SimpleCommandHandler;

/**
* A simple worker that does not execute the command. It only registers itself in the test spy
*/
class IntactCommandFakeWorker extends FakeCommandWorker
{
	
	function execute(Command $command)
	{
		$this->spy->registerWorker($this);
		$this->delegateNext($command);
	}
}


?>