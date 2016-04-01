<?php

namespace Milhojas\Infrastructure\Network;

use  Milhojas\Library\ValueObjects\Technical\Ip;
use  Milhojas\Domain\It\DeviceStatus;

/**
* Retrieves information for a device that show a status web page
*/
class WebDeviceStatus implements DeviceStatus
{
	const LIFETIME = 30;
	
	private $ip;
	private $status;
	private $url;
	private $lastCheck = 0;
	
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
	
	public function updateStatus($force = false)
	{
		if ($this->shouldReloadStatus($force)) {
			$this->status = $this->requestStatus();
			$this->lastCheck = microtime(true);
		}
		return $this->status;
	}
	
	private function requestStatus()
	{
		$url = sprintf('http://%s/%s', $this->ip->getIp(), $this->url);
		return file_get_contents($url);
		// $handler = curl_init($url);
		// $response = curl_exec($handler);
		// curl_close($handler);
		// return $response;
	}

	private function shouldReloadStatus($force)
	{
		if ($this->statusMustBeReloaded($force)) {
			return true;
		}
		return $this->loadedStatusIsTooOld();
	}
	
	private function statusMustBeReloaded($force)
	{
		return ($force || empty($this->status));
	}
	
	private function loadedStatusIsTooOld()
	{
		$ageInSeconds = microtime(true) - $this->lastCheck;
		if (($ageInSeconds) > static::LIFETIME ) {
			return true;
		}
		return false;
	}
	
	public function getIp()->getPort()
	{
		return $this->ip->getIp()->getPort();
	}
	
}

?>