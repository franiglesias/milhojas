<?php

namespace Tests\Application;

use Milhojas\Library\CommandBus\BasicCommandBus;
use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;


use Tests\Library\CommandBus\Utils\CommandBusSpy;
use Tests\Library\CommandBus\Fixtures\ExecuteCommandFakeWorker;
use Tests\Library\CommandBus\Fixtures\IntactCommandFakeWorker;
use Tests\Library\CommandBus\Fixtures\SimpleCommand;
use Tests\Library\CommandBus\Fixtures\SimpleCommandHandler;


class CommandBusTest extends \PHPUnit_Framework_Testcase {
	
	private $busUnderTest;
	
	public function dont_test_it_is_a_command_bus()
	{
		$bus = new BasicCommandBus(array(
			
		));
		$this->assertInstanceOf('Milhojas\Library\CommandBus\CommandBus', $bus);
	}
	
	public function dont_test_it_accepts_command_workers()
	{
		$bus = new BasicCommandBus(array(
			new ExecuteCommandFakeWorker()
		));
	}
	
	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function dont_test_it_does_not_accept_other_objetcs()
	{
		$bus = new BasicCommandBus(array(
			new \stdClass()
		));
	}
	
	public function withBus(CommandBus $busUnderTest)
	{
		$this->busUnderTest = new CommandBusSpy($busUnderTest);
		return $this;
	}
	
	public function sendingCommand(Command $command)
	{
		$this->busUnderTest->execute($command);
		return $this;
	}
	
	public function producesPipeline(array $expectedPipeline)
	{
		$this->assertEquals($expectedPipeline, $this->busUnderTest->getPipeline());
		return $this;
	}
	
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
				]);
	}
}


?>