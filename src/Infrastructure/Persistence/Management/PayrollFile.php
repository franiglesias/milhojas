<?php

namespace Milhojas\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\Exceptions\MalformedPayrollFileName;
/**
* Represents a Payrollfile. Acts as a decorator for SplFileInfo
*/
class PayrollFile
{
	private $file;
	private $idPattern;
	private $namePattern;
	
	public function __construct(\SplFileInfo $file)
	{
		$this->idPattern = '/trabajador_(\d+_\d+)/';
		$this->namePattern = '/nombre_\((.*), (.*)\)/';
		$this->checkFileName($file);
		$this->file = $file;

	}
	
	public function extractId()
	{
		preg_match($this->idPattern, $this->file->getBaseName(), $matches);
		return $matches[1];
	}
	
	public function extractName()
	{
		preg_match($this->namePattern, $this->file->getBaseName(), $matches);
		return mb_convert_case($matches[2].' '.$matches[1], MB_CASE_TITLE);
	}
	
	public function getRealPath()
	{
		$path = $this->file->getRealPath();
		// getRealPath is not supported in vfs test situations
		if (!$path) {
			return $this->file->getPathname();
		}
		return $path;
	}
	
	private function checkFileName($file)
	{
		$filename = $file->getBaseName();
		if (! preg_match($this->idPattern, $filename, $matches)) {
			throw new MalformedPayrollFileName(sprintf('Unable to recognize id in: %s', $filename), 1);
		}
		if (! preg_match($this->namePattern, $filename, $matches)) {
			throw new MalformedPayrollFileName(sprintf('Unable to recognize name in: %s', $filename), 2);
		}
	}
}

?>