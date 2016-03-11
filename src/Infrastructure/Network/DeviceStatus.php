<?php

namespace Milhojas\Infrastructure\Network;

interface DeviceStatus {
	public function isUp();
	public function isListening();
	public function getStatus($force = false);
}

?>