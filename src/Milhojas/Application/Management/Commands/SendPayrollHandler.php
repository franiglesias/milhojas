<?php

namespace Milhojas\Application\Management\Commands;

# Domain concepts

use Milhojas\Domain\Management\Payrolls;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Domain\Management\Employee;
# Events

use Milhojas\Application\Management\Events\PayrollEmailWasSent;
use Milhojas\Application\Management\Events\PayrollEmailCouldNotBeSent;
use Milhojas\Application\Management\Events\PayrollCouldNotBeFound;

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
	private $payrolls;
	private $template;
	private $mailer;
	private $recorder;
	
	public function __construct(Payrolls $payrolls, $template, Mailer $mailer, EventRecorder $recorder)
	{
		$this->mailer = $mailer;
		$this->recorder = $recorder;
		$this->payrolls = $payrolls;
		$this->template = $template;
	}
	
	/**
	 * Gets the employee, prepares and sends an email message with the payrolls attached
	 *
	 * @param Command $command 
	 * @return Events
	 * @author Fran Iglesias
	 */
	public function handle(Command $command)
	{
		$employee = $command->getEmployee();
		try {
			$this->sendEmail($employee, $command->getSender(), $command->getPaths(), $command->getMonth());
			$this->recorder->recordThat(new PayrollEmailWasSent($employee, $command->getProgress()->addSent()));
		} 
		catch (EmployeeHasNoPayrollFiles $e) {
			$this->recorder->recordThat(new PayrollCouldNotBeFound($employee, $command->getProgress()->addNotFound()));
		}
		catch (\Swift_SwiftException $e) {
			$this->recorder->recordThat(new PayrollEmailCouldNotBeSent($employee, $e->getMessage(), $command->getProgress()->addFailed()));
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
	private function sendEmail(Employee $employee, $sender, $paths, PayrollMonth $month)
	{
		$message = new MailMessage();
		$message
			->setTo($employee->getEmail())
			->setSender($sender)
			->setTemplate($this->template, array('employee' => $employee, 'month' => $month))
			->attach($this->getPayrollDocuments($employee, $paths, $month));
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
	private function getPayrollDocuments(Employee $employee, $paths, PayrollMonth $month)
	{
		$files = $this->payrolls->getForEmployee($employee, $month, $paths);
		$paths = array();
		foreach ($files as $file) {
			$paths[] = $file->getPath();
		}
		return $paths;
	}
	
}

?>
