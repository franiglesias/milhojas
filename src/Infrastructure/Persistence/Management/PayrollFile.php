<?php

namespace Milhojas\Infrastructure\Persistence\Management;

/**
* Represents a Payrollfile. Acts as a decorator for SplFileInfo
*/
class PayrollFile
{
	var $file;
	
	public function __construct(\SplFileInfo $file)
	{
		$this->file = $file;
	}
	
	public function extractId()
	{
		$filename = $this->file->getBaseName();
		preg_match('/trabajador_(\d+_\d+)/',$filename, $matches);
		if (!isset($matches[1])) {
			return false;
		}
		return $matches[1];
	}
	
	public function extractName()
	{
		$filename = $this->file->getBaseName();
		preg_match('/nombre_\((.*), (.*)\)/', $filename, $matches);
		if (! isset($matches[1]) || !isset($matches[2])) {
			return null;
		}
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
}

?>