<?php

namespace Milhojas\Infrastructure\Network\Printers;

interface PrinterDriverInterface {
	public function tonerLevelForColor($color, $status);
	public function paperLevelForTray($tray, $status);
	public function guessServiceCode($status);
	public function getVendorInformation();
}

?>