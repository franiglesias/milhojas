<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\CommandWorker;
use Milhojas\Library\CommandBus\Command;

use Tests\Library\CommandBus\Fixtures\SimpleCommandHandler;

/**
* A simple worker that does not execute the command. It only registers itself in the test spy
*/
class IntactCommandTestWorker implements CommandWorker
{
	public function __construct()
	{
	}
	
	
	function execute(Command $command)
	{
	}
}


?>