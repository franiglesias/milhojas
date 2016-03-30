<?php

namespace Milhojas\Infrastructure\Network;

use  Milhojas\Library\ValueObjects\Technical\Ip;
use  Milhojas\Domain\It\DeviceStatus;

/**
* Retrieves information for a device that show a status web page
*/
class WebDeviceStatus implements DeviceStatus
{
	private $ip;
	private $status;
	private $url;
	
	public function __construct(Ip $ip, $url)
	{
		$this->ip = $ip;
		$this->url = $url;
		$this->status = false;
	}
	
	public function isUp()
	{
		return $this->ip->isUp();
	}
	
	public function isListening()
	{
		return $this->ip->isListening();
	}
	
	public function getStatus($force = false)
	{
		if ($this->shouldReloadStatus($force)) {
			$this->status = $this->requestStatus();
		}
		return $this->status;
	}
	
	private function requestStatus()
	{
		return file_get_contents(sprintf('http://%s/%s', $this->ip->getIp(), $this->url));
	}

	private function shouldReloadStatus($force)
	{
		return ($force || empty($this->status));
	}
}

?>