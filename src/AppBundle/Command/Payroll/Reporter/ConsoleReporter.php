<?php

namespace AppBundle\Command\Payroll\Reporter;
/**
* Description
*/
class ConsoleReporter extends ReporterDecorator
{
	private $output;
	
	function __construct($reporter, $output)
	{
		parent::__construct($reporter);
		$this->output = $output;
	}
	
	public function report()
	{
		$lines = $this->reporter->report();
		$this->output->writeln(chr(10));
		foreach ($lines as $line) {
			$this->output->writeln($line);
		}
		return $lines;
	}
}

?>