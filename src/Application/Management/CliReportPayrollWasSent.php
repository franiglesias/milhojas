<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
use Symfony\Component\Console\Output\OutputInterface;
/**
* Handles PayrollWasSent and reports via cli
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
		$message = sprintf('%s. <options=bold>%s.</> was sent', $event->getProgress(), $event->getPayroll());
		$this->output->writeln($message);
	}
	
	
}
?>