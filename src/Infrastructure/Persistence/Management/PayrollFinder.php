<?php

namespace Milhojas\Infrastructure\Persistence\Management;


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

	// Find only files with valid names
	public function getFiles($path)
	{
		$this->finder->files()->in($path)->name('/trabajador_(\d+_\d+)/');
	}

	public function getIterator()
	{
		return $this->finder;
	}
	
	public function count()
	{
		return iterator_count($this->finder);
	}

}

?>