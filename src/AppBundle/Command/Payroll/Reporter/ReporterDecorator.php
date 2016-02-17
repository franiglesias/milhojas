<?php

namespace AppBundle\Command\Payroll\Reporter;

abstract class ReporterDecorator
{
	protected $reporter;
	
	function __construct($reporter)
	{
		$this->reporter = $reporter;
	}
	
	public function add($line)
	{
		$this->reporter->add($line);
	}
	
	abstract public function report();

	public function count()
	{
		$this->reporter->count();
	}
}

?>