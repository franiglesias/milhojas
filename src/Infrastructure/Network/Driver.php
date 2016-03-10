<?php

namespace Milhojas\Infrastructure\Network;

interface Driver {
	public function needsSupplies();
	public function needsService();
	public function getReport();
}

?>