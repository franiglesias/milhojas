<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\Workers\CommandWorker;
use Milhojas\Library\CommandBus\Command;

use Tests\Library\CommandBus\Fixtures\SimpleCommandHandler;

/**
* A simple worker that does not execute the command. It only registers itself in the test spy
*/
class IntactCommandFakeWorker implements CommandWorker
{
	public function __construct()
	{
	}
	
	
	function execute(Command $command)
	{
	}
}


?>