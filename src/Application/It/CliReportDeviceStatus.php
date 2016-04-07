<?php

namespace Milhojas\Application\It;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
use Symfony\Component\Console\Output\OutputInterface;
/**
* Handles events related to Device Status
*/
class CliReportDeviceStatus implements EventHandler
{
	private $output;
	
	function __construct(OutputInterface $output)
	{
		$this->output = $output;
	}
	
	public function handle(Event $event)
	{
		$this->output->writeln('<options=bold>'.$event->getDevice().'</> reports the following:');
		$this->output->writeln('<error>');
		$this->output->writeln( explode(chr(10), $event->getDetails() ) );
		$this->output->writeln('</>');
	}
	
	
}
?>