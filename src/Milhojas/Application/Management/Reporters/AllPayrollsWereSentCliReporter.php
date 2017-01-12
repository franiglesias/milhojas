<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\Messaging\EventBus\Reporter\CliReporter;
use Milhojas\Library\Messaging\EventBus\Event;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\StringInput;
/**
* Creates a cli report when all payrolls are sent
* 
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
