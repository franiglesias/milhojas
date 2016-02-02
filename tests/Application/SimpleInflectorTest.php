<?php

namespace Milhojas\Tests\Application;

use \Milhojas\Application\Inflectors\SimpleInflector;
use \Milhojas\Application\Command;

class CreateUser implements Command {
	
}

class DeleteUser implements Commnad {

}

class InspectUserCommand implements Command {
	
}

class SimpleInflectorTest extends \PHPUnit_Framework_Testcase {
	
	public function test_it_inflects_commands()
	{
		$inflector = new SimpleInflector();
		$handler = $inflector->inflect(new CreateUser);
		$this->assertEquals('CreateUserHandler', $handler);
	}
}

?>