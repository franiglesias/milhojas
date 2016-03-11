<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Infrastructure\Network\Printers\PrinterAdapter;
/**
* Description
*/
class Printer 
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
	
	public function requestStatus(DeviceReporter $reporter)
	{
		$this->adapter->requestStatus($reporter->requestStatus($this->adapter->getStatusUrl()));
	}
}

?>