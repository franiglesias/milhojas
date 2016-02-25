<?php

namespace Milhojas\Infrastructure\Persistence\Management;

/**
* Iterator to access payroll files
*/
class PayrollFinder
{
	private $path;
	
	function __construct($path)
	{
		$this->path = $path;
	}
}

?>