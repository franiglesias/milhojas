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
class CliReportPayrollCouldNotBeSent implements EventHandler
{
	private $output;
	
	function __construct(OutputInterface $output)
	{
		$this->output = $output;
	}
	
	public function handle(Event $event)
	{
		$this->output->writeln('<error>Payroll for <options=bold>'.$event->getWorker().'</> could not be sent</>');
	}
	
	
}
?>