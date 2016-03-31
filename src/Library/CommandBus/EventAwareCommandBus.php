<?php

namespace Milhojas\Library\CommandBus;

use Milhojas\Library\CommandBus\CommandBus;
use Milhojas\Library\CommandBus\BasicCommandBus;

use Milhojas\Library\EventBus\EventBus;
use Milhojas\Library\EventBus\EventRecorder;


/**
* A very Basic Command Bus that builds a chain of responsibility with an array of workers and can manage Events
*/

class EventAwareCommandBus extends BasicCommandBus
{
	protected $eventBus;
	protected $recorder;
	
	function __construct(array $workers, EventBus $eventBus, EventRecorder $recorder)
	{
		$this->workersChain = $this->buildWorkersChain($workers);
		$this->eventBus = $eventBus;
		$this->recorder = $recorder;
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
		$this->workersChain->execute($command);
		foreach ($this->recorder as $event) {
			$this->eventBus->handle($event);
		}
	}
}
?>