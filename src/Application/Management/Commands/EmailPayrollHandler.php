<?php

namespace Milhojas\Application\Management\Commands;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;

use Milhojas\Library\EventBus\EventRecorder;

use Milhojas\Domain\Management\Payrolls;
# Events

use Milhojas\Domain\Management\Events\PayrollWasSent;
use Milhojas\Domain\Management\Events\PayrollCouldNotBeSent;


/**
* Manages SendPayroll command
*/

class EmailPayrollHandler implements CommandHandler
{
	private $mailer;
	private $recorder;
	private $payrolls;
	
	public function __construct(Payrolls $payrolls, Mailer $mailer, EventRecorder $recorder)
	{
		$this->mailer = $mailer;
		$this->recorder = $recorder;
		$this->payrolls = $payrolls;
	}
	
	public function handle(Command $command)
	{
		$employee = $command->getEmployee();
		$files = $this->payrolls->getByMonthAndEmployee($command->getMonth());
		
		if ($this->sendEmail($employee, $files, $command->getSender(), $command->getMonth())) {
			$this->recorder->recordThat(new PayrollWasSent($payroll, $command->getProgress()));
		    unlink($payroll->getFile());
			return;
		}

		$this->recorder->recordThat(new PayrollCouldNotBeSent($payroll, $command->getProgress()));
	}
	
	private function sendEmail($employee, $files, $sender, $month)
	{
		$message = new MailMessage();
		$message
			->setTo($employee->getEmail())
			->setSender($sender)
			->setTemplate('AppBundle:Management:payroll.email.twig', array('payroll' => $payroll, 'month' => $month));
		foreach ($files as $file) {
			$message->attach($file->getPath());
		}
		return $this->mailer->send($message);
	}
	
}

?>
