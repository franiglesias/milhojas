<?php

namespace Milhojas\Domain\Contents\Flags;

/**
* Description
*/
class FlagFactory
{
	var $flags;
	
	public function __construct()
	{
		$flags = array();
	}
	
	function get($flag)
	{
		if (!isset($this->flags[$flag])) {
			$class = '\\Milhojas\\Domain\\Contents\\Flags\\'.$flag.'Flag';
			if (!class_exists($class)) {
				throw new \InvalidArgumentException($flag.'Flag does not exist.');
			}
			$this->flags[$flag] = new $class();
		}
		return $this->flags[$flag];
	}
}

?>