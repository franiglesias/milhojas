<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
use Symfony\Component\Console\Output\OutputInterface;
/**
* Handles events related to Device Status
*/
class CliReportPayrollWasSent implements EventHandler
{
	private $output;
	
	function __construct(OutputInterface $output)
	{
		$this->output = $output;
	}
	
	public function handle(Event $event)
	{
		$this->output->writeln('<options=bold>'.$event->getPayroll().'</> was sent');
	}
	
	
}
?>