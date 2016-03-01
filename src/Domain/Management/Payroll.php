<?php

namespace Milhojas\Domain\Management;

/**
 * Represents a Payroll file
 * 
 * You must use PayrollRepository::get('file') to create a new payroll ready to use
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
class Payroll {
	private $id; // Identifies the employee
	private $name; // Name of the employee
	private $path; // Path to the pshysical file associated
	private $email; // Email to send the file
	
	public function __construct($id, $name, $email, $path)
	{
		$this->name = $name;
		$this->id = $id;
		$this->email = $email;
		$this->path = $path;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function getFile()
	{
		return $this->path;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getTo()
	{
		return array($this->email => $this->name);
	}
	
}


?>