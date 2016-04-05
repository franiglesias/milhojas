<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
use Symfony\Component\Console\Output\OutputInterface;
/**
* Handles the event that payroll could not be sent and reports via CLI
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
		$this->output->writeln('<error>Payroll for <error options=bold>'.$event->getWorker().'</> could not be sent</>');
	}
	
	
}
?>