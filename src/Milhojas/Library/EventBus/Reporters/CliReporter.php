<?php

namespace Milhojas\Library\EventBus\Reporters;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;
use Symfony\Component\Console\Output\OutputInterface;
/**
* CliReporter is an event handler that can output to the console
*/
abstract class CliReporter implements EventHandler
{
	protected $output;
	
	public function __construct(OutputInterface $output)
	{
		$this->output = $output;
	}
	
	abstract public function handle(Event $event);
	
}
?>
