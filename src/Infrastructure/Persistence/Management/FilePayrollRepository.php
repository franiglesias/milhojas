<?php

namespace Milhojas\Infrastructure\Persistence\Management;

use Milhojas\Domain\Management\PayrollRepository;
use Milhojas\Domain\Management\Payroll;
use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;

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
	
	private $emails;
	private $finder;
	private $root;
	
	public function __construct($root, PayrollFinder $finder)
	{
		$this->isValidRoot($root);
		$this->isValidEmailData($root);
		
		$this->root = $root;
		$this->emails = $this->load($root.'/email.dat');
		$this->finder = $finder;
	}
	
	public function get($payrollFile)
	{
		$id = $payrollFile->extractId();
		$Payroll = new Payroll(
			$id, 
			$payrollFile->extractName(), 
			$this->emails[$id],
			$payrollFile->getRealPath()
		);
		return $Payroll;
	}
	
	public function finder()
	{
		return $this->finder;
	}
	
	public function getFiles($month)
	{
		if (!file_exists($this->root.'/'.$month)) {
			throw new Exceptions\InvalidPayrollData(sprintf('There is not a folder for mont: %s. Check spelling.', $month), 3);
			
		}
		$this->finder->getFiles($this->root.'/'.$month);
		return $this->finder;
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
	
	private function isValidRoot($root)
	{
		if (! file_exists($this->root)) {
			throw new Exceptions\InvalidPayrollData(sprintf('This is not a valid root for payroll: %s.', $this->root), 1);
		}
	}
	
	private function isValidEmailData($root)
	{
		if (! file_exists($this->root.'/email.dat')) {
			throw new Exceptions\InvalidPayrollData(sprintf('There is not email.dat file in %s.', $this->root), 2);
		}
	}
}



?>