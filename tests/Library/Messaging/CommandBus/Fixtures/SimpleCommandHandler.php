<?php

namespace Tests\Library\Messaging\CommandBus\Fixtures;

use Milhojas\Library\Messaging\CommandBus\CommandHandler;
use Milhojas\Library\Messaging\CommandBus\Command;

class SimpleCommandHandler implements CommandHandler {
	

	public function __construct()
	{
	}
	public function handle(Command $command)
	{
	}
}


?>
