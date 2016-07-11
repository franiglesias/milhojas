<?php

namespace Milhojas\Library\EventBus\Reporters;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
use Symfony\Component\Console\Output\OutputInterface;
/**
* Handles the event that payroll could not be sent and reports via CLI
*/
abstract class CliReporter implements EventHandler
{
	protected $output;
	
	function __construct(OutputInterface $output)
	{
		$this->output = $output;
	}
	
	abstract public function handle(Event $event);
	
}
?>