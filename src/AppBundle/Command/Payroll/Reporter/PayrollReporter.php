<?php

namespace AppBundle\Command\Payroll\Reporter;

/**
* A class to generate reports for the Payroll commnand
*/
class PayrollReporter
{
	private $lines;
	private $total;
	private $errors;
	
	
	function __construct($total)
	{
		$this->lines = array();
		$this->errors = array();
		$this->total = $total;
	}
	
	public function add($line)
	{
		$this->lines[] = $line;
	}
	
	public function report()
	{
		array_unshift($this->lines, sprintf('%s of %s messages sent.', $this->total - count($this->errors), $this->total));
		$this->lines += $this->errors;
		return $this->lines;
	}
	
	public function error($line)
	{
		$this->errors[] = 'ERROR: '.$line;
	}
}

?>