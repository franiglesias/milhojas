<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\EventBus\Reporters\CliReporter;
use Milhojas\Library\EventBus\Event;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\StringInput;
/**
* Responds to PostWasUpdated Event
* 
* Sends an e email message to notify that a post has been updated
*/
class AllPayrollsWereSentCliReporter extends CliReporter
{	

	public function handle(Event $event)
	{
		$io = new SymfonyStyle(new StringInput(''), $this->output);
		$io->section('Payroll sending report');
		$io->table(
			array('Month', $event->getMonth()),
			array(
				array('Employees', $event->getProgress()->getTotal()),
				array('Sent emails', $event->getProgress()->getSent()),
				array('Payrolls not found', $event->getProgress()->getNotFound()),
				array('Emails Failed', $event->getProgress()->getFailed())
			)
		);
	}
 }
?>
