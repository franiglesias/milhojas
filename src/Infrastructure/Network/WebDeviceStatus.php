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
		$url = sprintf('http://%s/%s', $this->ip->getIp(), $this->url);
		return file_get_contents($url);
		$handler = curl_init($url);  
		$response = curl_exec($handler);  
		curl_close($handler);  
		return $response;  
	}

	private function shouldReloadStatus($force)
	{
		return ($force || empty($this->status));
	}
}

?>