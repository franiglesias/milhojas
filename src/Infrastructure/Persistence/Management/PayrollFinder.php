<?php

namespace Milhojas\Infrastructure\Persistence\Management;

use Symfony\Component\Finder\Finder;

/**
* Iterator to access payroll files. Uses Symfony Finder Component to access the available files
*/

class PayrollFinder implements \IteratorAggregate
{

	private $finder;
	
	function __construct($finder)
	{
		$this->finder = $finder;
	}
	
	public function getFiles($path)
	{
		// Find only files with valid names
		$this->finder->files()->in($path)->name('/nombre_\((.*), (.*)\).*trabajador_(\d+_\d+)/');
	}
	
	public function getIterator()
	{
		return $this->finder;
	}
	
}

?>