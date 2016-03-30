<?php

namespace Milhojas\Domain\It;

/**
 * Interface for a class that can provide status information for a device
 *
 * @package default
 * @author Fran Iglesias
 */

interface DeviceStatus {
	public function isUp();
	public function isListening();
	public function getStatus($force = false);
}

?>