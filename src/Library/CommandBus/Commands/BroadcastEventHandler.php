<?php

namespace Milhojas\Library\CommandBus\Commands;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

use Milhojas\Library\EventBus\EventRecorder;

/**
* Broadcasts an event
* 
* Handles the broadcasting of an event
*/
class BroadcastEventHandler implements CommandHandler
{
	private $recorder;
	
	public function __construct(EventRecorder $recorder)
	{
		$this->recorder = $recorder;
	}
	
	public function handle(Command $command)
	{
		$this->recorder->recordThat($command->getEvent());
	}
}


?>