<?php

namespace Milhojas\Infrastructure\Network;

/**
 * Represents a Device connected to the net. The device can be asked if is up, is listening in a port, nneds service or needs supplies
 * 
 * Also, can generate a Report
 *
 * @package default
 * @author Francisco Iglesias Gómez
 */

interface Device {
	public function isUp();
	public function isListening();
	public function needsService();
	public function needsSupplies();
	public function getReport();
	public function getIdentity();
}

?>