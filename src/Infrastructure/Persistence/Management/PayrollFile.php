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
	
	public function __construct(\SplFileInfo $file)
	{
		$this->idPattern = '/trabajador_(\d+)/';
		$this->isWellFormedFileName($file);
		$this->file = $file;
	}
	
	public function extractId()
	{
		preg_match($this->idPattern, $this->file->getBaseName(), $matches);
		return $matches[1];
	}
		
	// getRealPath is not supported in vfs test situations
	public function getRealPath()
	{
		$path = $this->file->getRealPath();
		if (!$path) {
			return $this->file->getPathname();
		}
		return $path;
	}
	
	private function isWellFormedFileName(\SplFileInfo $file)
	{
		$filename = $file->getBaseName();
		if (! preg_match($this->idPattern, $filename, $matches)) {
			throw new MalformedPayrollFileName(sprintf('Unable to recognize id in: %s', $filename), 1);
		}
	}
}

?>
