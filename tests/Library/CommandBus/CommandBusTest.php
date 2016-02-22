<?php

namespace Tests\Application;

use Milhojas\Library\CommandBus\BasicCommandBus;
use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

class MakeDumb implements Command {
	private $message;
	public $spy;
	
	public function __construct($message, $spy)
	{
		$this->message = $message;
		$this->spy = $spy;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
}

class MakeDumbHandler implements CommandHandler {
	
	
	public function __construct()
	{

	}
	public function handle(Command $command)
	{
		$command->spy->add($command->getMessage());
	}
}

/**
* Description
*/
class MiddleWareTest implements CommandBus
{
	public function __construct()
	{
	}
	
	
	function execute(Command $command)
	{
		$handler = new MakeDumbHandler();
		$handler->handle($command);
	}
}

/**
* Description
*/
class SpyTest
{
	private $lines;
	function __construct()
	{
		$this->lines = array();
	}
	
	public function add($line)
	{
		$this->lines[] = $line;
	}
	
	public function getResult()
	{
		return $this->lines;
	}
}

class CommandBusTest extends \PHPUnit_Framework_Testcase {
	
	private function getContainer()
	{
		return $this->getMockBuilder('Milhojas\Library\CommandBus\Container')
			->getMock();
	}
	
	public function getInflector()
	{
		return $this->getMockBuilder('Milhojas\Library\CommandBus\Inflector')
			->getMock();
		
	}
	
	public function test_it_is_a_command_bus()
	{
		$bus = new BasicCommandBus(array(
			
		));
		$this->assertInstanceOf('Milhojas\Library\CommandBus\CommandBus', $bus);
	}
	
	public function test_it_accepts_middleware_command_buses()
	{
		$bus = new BasicCommandBus(array(
			new MiddleWareTest()
		));
	}
	
	public function test_executes_a_command_passing_trough_loaded_middlewares()
	{
		$spy = new SpyTest();
		$bus = new BasicCommandBus(array(
			new MiddleWareTest(),
			new MiddleWareTest()
		));
		$bus->execute(new MakeDumb('Message 1', $spy));
		$this->assertEquals(array('Message 1', 'Message 1'), $spy->getResult());
	}
}


?>