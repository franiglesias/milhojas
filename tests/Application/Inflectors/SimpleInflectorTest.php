<?php

namespace Tests\Application;

use Milhojas\Application\Inflectors\SimpleInflector;
use Milhojas\Application\Command;

// class CreateUser implements Command {
//
// }
//
// class DeleteUser implements Command {
//
// }
//
// class InspectUserCommand implements Command {
//
// }

class SimpleInflectorTest extends \PHPUnit_Framework_Testcase {
	
	public function test_it_inflects_commands()
	{
		$handler = (new SimpleInflector())->inflect(new CreateUser);
		$this->assertEquals('Tests\Application\CreateUserHandler', $handler);
		$handler = (new SimpleInflector())->inflect(new DeleteUser);
		$this->assertEquals('Tests\Application\DeleteUserHandler', $handler);
		$handler = (new SimpleInflector())->inflect(new InspectUserCommand);
		$this->assertEquals('Tests\Application\InspectUserHandler', $handler);
		
	}
}

?>