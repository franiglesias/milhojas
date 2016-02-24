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
	
	public function test_executes_a_command_passing_trough_loaded_command_workers()
	{

		$bus = new BasicCommandBus(array(
			new IntactCommandFakeWorker(),
			new ExecuteCommandFakeWorker(),
			new IntactCommandFakeWorker(),
		));
		$spy = new CommandBusSpy($bus);
		$spy->execute(new SimpleCommand('Message 1'));
		$this->assertEquals(array(
				'IntactCommandFakeWorker',
				'ExecuteCommandFakeWorker',
				'IntactCommandFakeWorker',
		), $spy->getPipeline());
		
		$this->assertEquals(array('SimpleCommand'), $spy->getCommandsExecuted());
		// echo(chr(10));
		// print_r($spy->getStory());
		// echo(chr(10));
	}
}


?>