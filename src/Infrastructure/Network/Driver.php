<?php

namespace Milhojas\Infrastructure\Network;

use Milhojas\Infrastructure\Network\DeviceReporter;

interface Driver {
	public function needsSupplies();
	public function needsService();
	public function getReport();
	public function requestStatus(DeviceReporter $reporter);
}

?>