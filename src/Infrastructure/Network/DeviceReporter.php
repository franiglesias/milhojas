<?php

namespace Milhojas\Infrastructure\Network;

use  Milhojas\Infrastructure\Network\DeviceIdentity;
/**
* Retrieves information for a device
*/
class DeviceReporter
{
	public function requestStatus(DeviceIdentity $device, $url)
	{
		return file_get_contents(sprintf('http://%s/%s', $device->getIp(), $url));
	}
}

?>