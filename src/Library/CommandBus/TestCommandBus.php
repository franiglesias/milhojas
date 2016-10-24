<?php

namespace Milhojas\Library\CommandBus;

use Milhojas\Library\CommandBus\CommandBus;

/**
* A very Basic Command Bus that builds a chain of responsibility with an array of workers
*/

class TestCommandBus implements CommandBus
{
	protected $commands;
	
	public function __construct()
	{
		$commands = array();
	}
	
	/**
	 * Execute command
	 *
	 * @param Command $command 
	 * @return void
	 * @author Fran Iglesias
	 */
	public function execute(Command $command)
	{
		$this->commands[] = get_class($command);
	}
	
	public function wasReceived($command)
	{
		return in_array($command, $this->commands);
	}
}
?>
