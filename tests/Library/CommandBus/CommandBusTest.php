<?php

namespace Tests\Application;

use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

class MakeDumb implements Command {
	
}

class MakeDumbHandler implements CommandHandler {
	public function handle(Command $command)
	{
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
	
	public function test_it_creates_command_bus()
	{
		$container = $this->getContainer();
		$inflector = $this->getInflector();
		$inflector->expects($this->once())->method('inflect')->will($this->returnValue('Tests\Application\MakeDumbHandler'));
		$container->expects($this->once())->method('make')->will($this->returnValue(new MakeDumbHandler));
		$bus = new CommandBus($container, $inflector);
		$bus->execute(new MakeDumb());
	}
}


?>