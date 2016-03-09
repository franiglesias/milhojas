<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Device;
use Milhojas\Infrastructure\Network\Printers\PrinterAdapter;
/**
* Represents a Printer
*/
class Printer
{
	
	private $device;
	private $adapter;
	
	function __construct(Device $device, PrinterAdapter $adapter)
	{
		$this->device = $device;
		$this->adapter = $adapter;
	}
}


?>