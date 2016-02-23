<?php

namespace Tests\Library\CommandBus\Fixtures;

use Milhojas\Library\CommandBus\CommandHandler;
use Milhojas\Library\CommandBus\Command;

class SimpleCommandHandler implements CommandHandler {
	

	public function __construct()
	{
	}
	public function handle(Command $command)
	{
	}
}


?>