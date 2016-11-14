<?php

namespace Milhojas\Library\CommandBus;

use Milhojas\Library\CommandBus\CommandBus;

/**
* A very Basic Command Bus that simply registes the commands received
*/

class TestCommandBus implements CommandBus
{
	protected $commands;
	
	public function __construct()
	{
		$this->commands = array();
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
	
	/**
	 * Checks if a command was receiven $times times
	 *
	 * @param string $command 
	 * @param string $times default 1
	 * @return boolean
	 * @author Fran Iglesias
	 */
	public function wasReceived($command, $times = 1)
	{
		$stat = array_count_values($this->commands);
		return $stat[$command] === $times;
	}
	
	public function getReceived()
	{
		return $this->commands;
	}
}
?>
