<?php

namespace Milhojas\Library\ValueObjects\Misc;

/**
* Describes the progress of a process
*/
class Progress
{
	protected $current;
	protected $total;

	public function __construct($current, $total)
	{
		$this->checkLimits($current, $total);
		$this->current = $current;
		$this->total = $total;
	}
	
	public function getCurrent()
	{
		return $this->current;
	}
	
	public function getTotal()
	{
		return $this->total;
	}
	
	public function getPercent()
	{
		return round($this->total * 100/$this->current, 2, PHP_ROUND_HALF_UP);
	}
	
	public function advance()
	{
		$this->checkLimits($this->current + 1, $this->total);
		$this->current++;
		return clone $this;
	}
	
	public function __toString()
	{
		$pad = strlen($this->total);
		return sprintf('%'.$pad.'s / %'.$pad.'s', $this->current, $this->total);
	}
	
	private function checkLimits($current, $total)
	{
		if ($current > $total) {
			throw new \OutOfBoundsException(sprintf('Current (%s) should be less or equal to Total (%s)', $current, $total));
		}
	}
}

?>
