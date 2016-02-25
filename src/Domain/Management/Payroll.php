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
	private $file;
	private $id;
	private $name;
	private $path;
	private $email;
	
	public function __construct($file)
	{
		$this->file = $file;
		$this->name = $this->extractNameFromFileName();
		$this->id = $this->extractIdFromFileName();
		$this->path = $this->file->getRealpath();
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
	
	public function setEmail($email)
	{
		$this->email = $email;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function getTo()
	{
		return array($this->email => $this->name);
	}
	
	private function extractNameFromFileName()
	{
		$filename = $this->file->getRelativePathname();
		preg_match('/nombre_\((.*), (.*)\)/', $filename, $matches);
		return mb_convert_case($matches[2].' '.$matches[1], MB_CASE_TITLE);
	}
	
	private function extractIdFromFileName()
	{
		$filename = $this->file->getRelativePathname();
		preg_match('/trabajador_(\d+_\d+)/',$filename, $matches);
		return $matches[1];
	}
}


?>