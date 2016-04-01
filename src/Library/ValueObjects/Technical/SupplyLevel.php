<?php

namespace Milhojas\Library\ValueObjects\Technical;

/**
* Description
*/
class SupplyLevel
{
	private $level;
	private $verboseLevels = array(
		'exhausted',
		'almost empty',
		'low',
		'medium',
		'high',
		'almost full'
	);
	
	function __construct($level)
	{
		$this->isValidLevel($level);
		$this->level = $level;
	}
	
	private function isValidLevel($level)
	{
		if ($level < 0 || $level > 5) {
			throw new \InvalidArgumentException("SupplyLevel valid values are 0 to 5.", 1);
		}
	}
	
	public function getLevel()
	{
		return $this->level;
	}
	
	public function getVerboseLevel()
	{
		return $this->verboseLevels[$this->level];
	}
	
	public function shouldReplace()
	{
		return $this->level <= 1;
	}
	
	public function exhausted()
	{
		return $this->level <1;
	}
	
	public function getGraph()
	{
		return sprintf('[%s]', str_pad(str_repeat('#', $this->level), 5, ' '));
	}
}

?>