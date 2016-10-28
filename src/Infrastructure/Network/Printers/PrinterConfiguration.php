<?php

namespace Milhojas\Infrastructure\Network\Printers;

/**
* VO Representing the concrete configuration of a Printer
*/
class PrinterConfiguration
{
	private $trays;
	private $colors;

	public function __construct($trays, $colors)
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
