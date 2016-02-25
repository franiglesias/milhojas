<?php

namespace Milhojas\Infrastructure\Persistence\Management;
/**
* Description
*/
class PayrollFile extends \SplFileInfo
{
	public function getRelativePathName()
	{
		return $this->getBasename();
	}
}

?>