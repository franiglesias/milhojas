<?php

namespace Milhojas\Infrastructure\Network\Printers;

use Milhojas\Library\ValueObjects\Technical\SupplyLevel;

class DSM745SupplyLevel extends SupplyLevel {
	
	private $levels = array(
		'01' => 5,
		'02' => 4,
		'03' => 3,
		'04' => 2,
		'05' => 1,
		'06' => 0
	);
	
	public function __construct($level)
	{
		$this->isValidLevel($level);
		parent::__construct($this->levels[$level]);
	}
	
	private function isValidLevel($level)
	{
		if (! isset($this->levels[$level])) {
			throw new \InvalidArgumentException(sprintf("Invalid level format %s provided by DSM745 Adapter", $level), 1);
		}
	}
	
}
?>