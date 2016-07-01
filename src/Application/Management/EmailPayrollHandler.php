<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;

use Milhojas\Library\EventBus\EventRecorder;

# Events

use Milhojas\Domain\Management\Events\PayrollWasSent;
use Milhojas\Domain\Management\Events\PayrollCouldNotBeSent;

# Contracts

use Milhojas\Domain\Management\PayrollRepository;

# VO

use Milhojas\Library\ValueObjects\Misc\Progress;

/**
* Manages SendPayroll command
*/

class EmailPayrollHandler implements CommandHandler
{
	private $mailer;
	private $templating;
	private $recorder;
	
	function __construct(Mailer $mailer, EventRecorder $recorder)
	{
		$this->mailer = $mailer;
		$this->recorder = $recorder;
	}
	
	public function handle(Command $command)
	{
		$payroll = $command->getPayroll();
		
		if ($payroll->getEmail()) {
			if ($this->sendEmail($payroll, $command->getSender(), $command->getMonth())) {
				$this->recorder->recordThat(new PayrollWasSent($payroll, $command->getProgress()));
			    unlink($payroll->getFile());
				return;
			}
		}
		$this->recorder->recordThat(new PayrollCouldNotBeSent($payroll, $command->getProgress()));
	}
	
	private function sendEmail($payroll, $sender, $month)
	{
		$message = new MailMessage();
		$message
			->setTo($payroll->getTo())
			->setSender($sender)
			->setTemplate('AppBundle:Management:payroll.email.twig', array('payroll' => $payroll, 'month' => $month))
			->attach($payroll->getFile()); 
		return $this->mailer->send($message);
	}
	
}

?>