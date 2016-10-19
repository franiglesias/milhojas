<?php

namespace Milhojas\Application\Management\Commands;

# Domain concepts

use Milhojas\Domain\Management\Payrolls;

# Events

use Milhojas\Domain\Management\Events\PayrollEmailWasSent;
use Milhojas\Domain\Management\Events\PayrollEmailCouldNotBeSent;
use Milhojas\Domain\Management\Events\PayrollCouldNotBeFound;

# Application Messaging infrastructure

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;
use Milhojas\Library\EventBus\EventRecorder;

# Mailer

use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;

# Exceptions

use Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles;

/**
* Manages SendPayroll command
*/

class SendPayrollHandler implements CommandHandler
{
	private $mailer;
	private $recorder;
	private $payrolls;
	private $template;
	
	public function __construct(Payrolls $payrolls, $template, Mailer $mailer, EventRecorder $recorder)
	{
		$this->mailer = $mailer;
		$this->recorder = $recorder;
		$this->payrolls = $payrolls;
		$this->template = $template;
	}
	
	public function handle(Command $command)
	{
		$employee = $command->getEmployee();
		try {
			if ($this->sendEmail($employee, $command->getSender(), $command->getMonth())) {
				$this->recorder->recordThat(new PayrollEmailWasSent($employee, $command->getProgress()));
				return;
			}
			$this->recorder->recordThat(new PayrollEmailCouldNotBeSent($employee, $command->getProgress()));
		} catch (EmployeeHasNoPayrollFiles $e) {
			$this->recorder->recordThat(new PayrollCouldNotBeFound($employee, $command->getProgress()));
		}
	}
	
	/**
	 * Builds and send the email message to the employee
	 *
	 * @param string $employee 
	 * @param string $sender 
	 * @param string $month 
	 * @return boolean true on success
	 * @author Fran Iglesias
	 */
	private function sendEmail($employee, $sender, $month)
	{
		$message = new MailMessage();
		$message
			->setTo($employee->getEmail())
			->setSender($sender)
			->setTemplate($this->template, array('employee' => $employee, 'month' => $month))
			->attach($this->getPayrollDocuments($employee, $month));
		return $this->mailer->send($message);
	}
	
	/**
	 * Gets an array of paths to the payroll documents associated to employee
	 *
	 * @param string $employee 
	 * @param string $month 
	 * @return array
	 * @author Fran Iglesias
	 */
	private function getPayrollDocuments($employee, $month)
	{
		$files = $this->payrolls->getByMonthAndEmployee($month, $employee);
		$paths = array();
		foreach ($files as $file) {
			$paths[] = $file->getPath();
		}
		return $paths;
	}
	
}

?>
