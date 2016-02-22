<?php

namespace Milhojas\Library\CommandBus;

use Milhojas\Library\CommandBus\CommandBus;
/**
* Description
*/
class BasicCommandBus implements CommandBus
{
	private $buses;
	
	function __construct(array $buses)
	{
		foreach ($buses as $bus) {
			$this->append($bus);
		}
	}
	
	public function append(CommandBus $bus)
	{
		$this->buses[] = $bus;
	}
	
	public function execute(Command $command)
	{
		foreach ($this->buses as $bus) {
			$bus->execute($command);
		}
	}
}
?>