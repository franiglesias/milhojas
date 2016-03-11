<?php

namespace Milhojas\Infrastructure\Network\Printers;

/**
* Description
*/
class PrinterConfiguration
{
	private $trays;
	private $colors;
	
	function __construct($trays, $colors)
	{
		$this->trays = $trays;
		$this->colors = $colors;
	}
	
	public function getTrays()
	{
		return $this->trays;
	}
	public function getColors()
	{
		return $this->colors;
	}
}

?>