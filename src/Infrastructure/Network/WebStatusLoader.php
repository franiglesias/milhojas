<?php

namespace Milhojas\Infrastructure\Network;

use  Milhojas\Library\ValueObjects\Technical\Ip;
use  Milhojas\Infrastructure\Network\StatusLoader;

/**
* Retrieves information for a device
*/
class WebStatusLoader implements StatusLoader
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
	
	private function requestStatus()
	{
		return file_get_contents(sprintf('http://%s/%s', $this->ip->getIp(), $this->url));
	}
	
	public function getStatus($force = false)
	{
		if ($this->shouldReloadStatus($force)) {
			$this->status = $this->requestStatus();
		}
		return $this->status;
	}
	
	public function shouldReloadStatus($force)
	{
		return ($force || empty($this->status));
	}
}

?>