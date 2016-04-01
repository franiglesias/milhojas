<?php

namespace Milhojas\Domain\It;

/**
 * Interface for a class that can provide status information for a device
 * Should be implemented in the Infrastructure Layer
 *
 * @package milhojas.domain.it
 * @author Fran Iglesias
 */

interface DeviceStatus {
	public function isUp();
	public function isListening();
	public function updateStatus($force = false);
	public function getIp();
}

?>