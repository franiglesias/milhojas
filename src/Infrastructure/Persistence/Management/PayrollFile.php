<?php

namespace Milhojas\Infrastructure\Persistence\Management;
/**
* Represents a Payrollfile
*/
class PayrollFile extends \SplFileInfo
{
	public function getRelativePathName()
	{
		return $this->getBasename();
	}
	
	public function extractId()
	{
		$filename = $this->getBaseName();
		preg_match('/trabajador_(\d+_\d+)/',$filename, $matches);
		return $matches[1];
	}
	
	public function extractName()
	{
		$filename = $this->getBaseName();
		preg_match('/nombre_\((.*), (.*)\)/', $filename, $matches);
		return mb_convert_case($matches[2].' '.$matches[1], MB_CASE_TITLE);
	}
}

?>