<?php

namespace Milhojas\Infrastructure\Persistence\Management;

use Milhojas\Domain\Management\PayrollRepository;
use Milhojas\Domain\Management\Payroll;
use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
use Milhojas\Infrastructure\Utilities\DataParser;

use Milhojas\Infrastructure\Persistence\Management\Exceptions as Exceptions;

/**
 * Repository/factory for payroll. It returns a Payroll object with all needed settings made
 * 
 * Needs the path to the emails.dat file
 * 
 * @package AppBundle.command.payroll
 * @author Francisco Iglesias Gómez
 */
class FilePayrollRepository implements PayrollRepository{
	
	private $finder;
	private $root;
	private $data;

	
	public function __construct($root, PayrollFinder $finder, DataParser $parser)
	{
		$this->rootExistsInFileSystem($root);
		$this->emailDataFileExistsInFileSystem($root);
		$this->root = $root;
		$this->data = $parser->parse(file($this->root.'/email.dat'));
		$this->finder = $finder;
	}
	
	public function get($payrollFile)
	{
		$id = $payrollFile->extractId();
		if (array_key_exists($id, $this->data)) {
			return $this->payrollFromDB($id, $payrollFile);
		}
		return $this->unknownPayroll($id, $payrollFile);
	}
	
	private function payrollFromDB($id, $payrollFile)
	{
		return new Payroll(
			$id, 
			$this->data[$id]['last'].', '.$this->data[$id]['name'], 
			$this->data[$id]['email'],
			$payrollFile->getRealPath(),
			$this->data[$id]['gender']
		);
	}
	
	private function unknownPayroll($id, $payrollFile)
	{
		return new Payroll(
			$id, 
			'Failed',
			'',
			$payrollFile->getRealPath(),
			''
		);

	}
		
	public function getFiles($month)
	{
		if (!file_exists($this->root.'/'.$month)) {
			throw new Exceptions\InvalidPayrollData(sprintf('There is not a folder for month: %s. Check spelling.', $month), 3);
		}
		$this->finder->getFiles($this->root.'/'.$month);
		return $this->finder;
	}
	
	public function count($month)
	{
		$this->getFiles($month);
		return iterator_count($this->finder);
	}
	
	private function rootExistsInFileSystem($root)
	{
		if (! file_exists($root)) {
			throw new Exceptions\InvalidPayrollData(sprintf('Unexistent of invalid root for payroll: %s.', $root), 1);
		}
	}
	
	private function emailDataFileExistsInFileSystem($root)
	{
		if (! file_exists($root.'/email.dat')) {
			throw new Exceptions\InvalidPayrollData(sprintf('There is not email.dat file in %s.', $root), 2);
		}
	}
}



?>
