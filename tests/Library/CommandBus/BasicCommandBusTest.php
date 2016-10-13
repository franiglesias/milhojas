<?php

namespace Tests\Library\CommandBus;

use Milhojas\Library\CommandBus\BasicCommandBus;
use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;


use Tests\Library\CommandBus\Utils\CommandBusSpy;
use Tests\Library\CommandBus\Utils\CommandBusTestCase;
use Tests\Library\CommandBus\Fixtures\ExecuteCommandFakeWorker;
use Tests\Library\CommandBus\Fixtures\IntactCommandFakeWorker;
use Tests\Library\CommandBus\Fixtures\SimpleCommand;
use Tests\Library\CommandBus\Fixtures\SimpleCommandHandler;


class BasicCommandBusTest extends CommandBusTestCase {
	
	public function test_executes_a_command_passing_trough_loaded_command_workers()
	{
		$this->withBus(new BasicCommandBus([
					new IntactCommandFakeWorker(),
					new ExecuteCommandFakeWorker(),
					new IntactCommandFakeWorker()
				]))
				->sendingCommand(new SimpleCommand('Message 1'))
				->producesPipeline([
					'IntactCommandFakeWorker',
					'ExecuteCommandFakeWorker',
					'IntactCommandFakeWorker'
				])
				->executes(['SimpleCommand']);
	}
}


?>
