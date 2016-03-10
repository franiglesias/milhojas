<?php

namespace Milhojas\Infrastructure\Network;

interface Device {
	public function isUp();
	public function isListening();
	public function needsService();
	public function needsSupplies();
	public function getReport();
}

?>