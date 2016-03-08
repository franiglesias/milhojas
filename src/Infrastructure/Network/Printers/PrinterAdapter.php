<?php

namespace Milhojas\Infrastructure\Network\Printers;

/**
* Interface for Printer adapters
*/
interface PrinterAdapter
{
	public function needsToner();
	public function needsPaper();
	public function needsService();
	public function getDetails();
}

?>