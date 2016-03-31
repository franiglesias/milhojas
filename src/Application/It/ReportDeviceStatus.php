<?php

namespace Milhojas\Application\It;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
/**
* Description
*/
class ReportDeviceStatus implements EventHandler
{
	private $mailer;
	
	function __construct(Mailer $mailer)
	{
		$this->mailer = $mailer;
	}
	
	public function handle(Event $event)
	{
		$device = $event->getDevice();
		echo $device.chr(10);
		echo $event->getDetails().chr(10);
		$this->sendEmail($device, $event->getDetails());
	}
	
	private function sendEmail($device, $details)
	{
		$message = new MailMessage();
		$message
			->setTo(array('frankie@miralba.org' => 'Frankie'))
			->setSender(array('frankie@miralba.org' => 'Frankie'))
			->setTemplate('AppBundle:It:device.email.twig', array('device' => $device, 'details' => $details));
		return $this->mailer->send($message);
	}
	
}
?>