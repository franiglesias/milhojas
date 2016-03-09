<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Library\ValueObjects\Technical\SupplyLevel;

class MPC4500SupplyLevel extends SupplyLevel {
	
	private $levels = array(
		'100' => 5,
		'75' => 4,
		'50' => 3,
		'25' => 2,
		'Nend' => 1,
		'end' => 0
	);
	
	public function __construct($level)
	{
		$this->isValidLevel($level);
		parent::__construct($this->levels[$level]);
	}
	
	private function isValidLevel($level)
	{
		if (! isset($this->levels[$level])) {
			throw new \InvalidArgumentException(sprintf("Invalid level format %s provided by MPC4500 Adapter", $level), 1);
		}
	}	
}
?>