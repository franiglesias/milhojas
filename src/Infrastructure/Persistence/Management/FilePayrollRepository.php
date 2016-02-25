<?php

namespace Milhojas\Infrastructure\Persistence\Management;

use Milhojas\Domain\Management\PayrollRepository;
use Milhojas\Domain\Management\Payroll;
/**
 * Repository/factory for payroll. It returns a Payroll object with all needed settings made
 * 
 * Needs the path to the emails.dat file
 * 
 * @package AppBundle.command.payroll
 * @author Francisco Iglesias Gómez
 */
class FilePayrollRepository implements PayrollRepository{
	
	private $emails;
	
	public function __construct($pathToFile)
	{
		// emails.dat
		$this->emails = $this->load($pathToFile);
	}
	
	public function get($payrollFile)
	{
		$Payroll = new Payroll($payrollFile);
		$Payroll->setEmail($this->emails[$Payroll->getId()]);
		return $Payroll;
	}
	
	private function load($path)
	{
		$emails = array();
		foreach (file($path) as $line) {
			list($id, $email) = explode(chr(9), $line);
			$emails[$id] = trim($email);
		}
		return $emails;
	}
}



?>