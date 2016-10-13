<?php

namespace Tests\Infrastructure\Network\Printers\Doubles;

use Milhojas\Domain\It\DeviceStatus;
use Milhojas\Library\ValueObjects\Technical\Ip;

/**
* Description
*/
class MockStatus implements DeviceStatus
{
	private $status;
public function __construct($service, $toner, $paper, $up = true, $listening = true)
	{
		$this->status = array(
			'service' => $service,
			'toner' => $toner,
			'paper' => $paper,
			'up' => $up,
			'listening' => $listening
		);
	}
	
	static public function working()
	{
		return new static(false, 5, 5);
	}
	
	static public function withoutPaper()
	{
		return new static(false, 5, 0);
	}

	static public function withoutToner()
	{
		return new static(false, 0, 5);
	}
	
	static public function needingService()
	{
		return new static('Error', 5, 5);
	}
	
	static public function down()
	{
		return new static(false, 5, 5, false, false);
	}
	
	static public function closed()
	{
		return new static(false, 5, 5, true, false);
	}
	
	public function isUp()
	{
		return $this->status['up'];
	}
	
	public function isListening()
	{
		return $this->status['listening'];
	}
	
	public function updateStatus($force = false)
	{
		return $this->status;
	}
	
	
	public function getIp()
	{
		return new Ip('127.0.0.1');
	}
	
}

?>
