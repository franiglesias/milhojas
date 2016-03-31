<?php

namespace Milhojas\Application\It;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;
/**
* Description
*/
class ReportDeviceStatus implements EventHandler
{
	private $mailer;
	
	function __construct($mailer)
	{
		$this->mailer = $mailer;
	}
	
	public function handle(Event $event)
	{
		$device = $event->getDevice();
		echo $device.chr(10);
		echo $event->getDetails().chr(10);
	}
}
?>