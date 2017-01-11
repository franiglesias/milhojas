<?php

namespace Tests\Library\Messaging\CommandBus\Fixtures;

use Milhojas\Library\Messaging\CommandBus\Command;

class SimpleCommand implements Command {
	private $message;
	
	public function __construct($message)
	{
		$this->message = $message;
	}
	
	public function getMessage()
	{
		return $this->message;
	}
}


?>
