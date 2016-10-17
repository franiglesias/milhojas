<?php

namespace Milhojas\Domain\Management;

/**
* Represents an Employee for Management purposes
*/
class Employee
{
	private $payrolls;
	private $email;
	private $firstname;
	private $lastname;
	private $gender;
	
	public function __construct($email, $firstname, $lastname, $gender, $payrolls)
	{
		$this->email     = $email;
		$this->firstname = $firstname;
		$this->lastname  = $lastname;
		$this->gender    = $gender;
		$this->payrolls  = $payrolls;
	}
	
	/**
	 * Returns the array of payroll codes for this employee
	 *
	 * @return array
	 * @author Fran Iglesias
	 */
	public function getPayrolls()
	{
		return $this->payrolls;
	}
	
	public function getFullName()
	{
		return $this->firstname.' '.$this->lastname;
	}
	
}

?>
