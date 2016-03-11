<?php

namespace Milhojas\Infrastructure\Network\Printers\PrinterDriver;

interface PrinterDriver {
	public function tonerLevelForColor($color);
	public function paperLevelForTray($tray);
	public function guessServiceCode();
	public function detectFail();
	public function requestStatus();
	public function getVendorInformation();
}

?>