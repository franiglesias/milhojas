<?php

namespace Milhojas\Infrastructure\Network\Printers;


/**
 * An interface to build Concrete Printer Drivers that can extract some information from $status
 * 
 * Vendor information is harcoded as class constants
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */
interface PrinterDriver {
	public function tonerLevelForColor($color, $status);
	public function paperLevelForTray($tray, $status);
	public function guessServiceCode($status);
	public function getVendorInformation();
}

?>