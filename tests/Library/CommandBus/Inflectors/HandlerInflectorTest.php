<?php

namespace Tests\Library\CommandBus;

use Milhojas\Library\CommandBus\Inflectors\HandlerInflector;
use Milhojas\Library\CommandBus\Command;

class CreateUser implements Command {
	
}

class DeleteUser implements Command {

}

class InspectUserCommand implements Command {
	
}

class HandlerInflectorTest extends \PHPUnit_Framework_Testcase {
	
	public function test_it_inflects_commands()
	{
		$handler = (new HandlerInflector())->inflect(new CreateUser);
		$this->assertEquals('create_user_handler', $handler);
		$handler = (new HandlerInflector())->inflect(new DeleteUser);
		$this->assertEquals('delete_user_handler', $handler);
		$handler = (new HandlerInflector())->inflect(new InspectUserCommand);
		$this->assertEquals('inspect_user_handler', $handler);
		
	}
}

?>