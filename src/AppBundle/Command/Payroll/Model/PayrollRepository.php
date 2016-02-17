<?php

namespace AppBundle\Command\Payroll\Model;

/**
 * Repository/factory for payroll. It returns a Payroll object with all needed settings made
 * 
 * @package AppBundle.command.payroll
 * @author Francisco Iglesias Gómez
 */
class PayrollRepository {
	private $emails;
	
	public function __construct($path)
	{
		$this->emails = $this->load($path.'/emails.dat');
	}
	
	public function get($file)
	{
		$Payroll = new Payroll($file);
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