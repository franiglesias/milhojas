<?php

namespace Tests\Application\Utils;

# Application Messaging
use Milhojas\Library\EventBus\EventRecorder;
use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;
use Milhojas\Library\CommandBus\TestCommandBus;

/**
 * Base class for test Command/CommandHandler scenarios.
 * Extend this to get a Testcase with fluent interface and dummy messagin structure
 *
 * @package default
 * @author Fran Iglesias
 */
class CommandScenario extends \PHPUnit_Framework_Testcase
{
	protected $command;
	protected $recorder;
	protected $bus;
	
	/**
	 * Allways call parent::setUp()
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function setUp()
	{
		$this->recorder = new EventRecorder();
		$this->bus = new TestCommandBus();
	}

	/**
	 * The Command we are testing
	 *
	 * @param Command $command 
	 * @return void
	 * @author Fran Iglesias
	 */
	protected function sending(Command $command)
	{
		$this->command = $command;
		return $this;
	}
	
	/**
	 * The handler we are testing
	 *
	 * @param CommandHandler $handler 
	 * @return void
	 * @author Fran Iglesias
	 */
	protected function toHandler(CommandHandler $handler)
	{
		$handler->handle($this->command);
		return $this;
	}
	
	/**
	 * Asserts if this event is raised to the Event Recorder
	 *
	 * @param string $eventName 
	 * @return void
	 * @author Fran Iglesias
	 */
	protected function raisesEvent($eventName)
	{
		$found = false;
		$eventName = $this->normalizeFQN($eventName);
		
		foreach ($this->recorder as $event) {
			if (get_class($event) == $eventName) {
				$found = true;
			}
		}
		$this->assertTrue($found, sprintf('%s Event was not raised.', $eventName));
		return $this;
	}
	/**
	 * $effect is the boolean result of some checking in other objects in the test
	 * like MailerStub or whatever you can check as boolean
	 *
	 * @param boolean $effect 
	 * @return self
	 * @author Fran Iglesias
	 */
	protected function produces($effect)
	{
		$this->assertTrue($effect);
		return $this;
	}

	/**
	 * Asserts id this Command was sent
	 *
	 * @param string $command 
	 * @return void
	 * @author Fran Iglesias
	 */
	protected function sendsCommand($command, $times = 1)
	{
		$command = $this->normalizeFQN($command);
		$this->assertTrue($this->bus->wasReceived($command, $times), sprintf('%s command not sent.', $command));
		return $this;
	}
	
	/**
	 * Normalize Fully Qualified names to allow comparation with the get_class result
	 *
	 * @param string $name 
	 * @return void
	 * @author Fran Iglesias
	 */
	private function normalizeFQN($name)
	{
		return $name[0] == '\\'? substr($name, 1) : $name;
	}
	
}

?>
