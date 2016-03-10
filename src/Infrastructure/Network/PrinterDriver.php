<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Driver;
use Milhojas\Infrastructure\Network\Printers\PrinterAdapter;
/**
* Description
*/
class PrinterDriver implements Driver
{
	private $adapter;
	
	function __construct(PrinterAdapter $adapter)
	{
		$this->adapter = $adapter;
	}
		
	public function needsSupplies()
	{
		return $this->adapter->needsPaper() || $this->adapter->needsToner();
	}
	
	public function needsService()
	{
		return $this->adapter->needsService();
	}
	
	public function getReport()
	{
		return $this->adapter->getReport();
	}
}

?>