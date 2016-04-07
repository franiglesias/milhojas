<?php

namespace Milhojas\Application\It;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
/**
* Handles events related to Device Status
*/
class ReportDeviceStatus implements EventHandler
{
	private $mailer;
	private $sender;
	private $report;
	
	function __construct(Mailer $mailer, $sender, $report)
	{
		$this->mailer = $mailer;
		$this->sender = $sender;
		$this->report = $report;
	}
	
	public function handle(Event $event)
	{
		$this->sendEmail($event->getDevice(), $event->getDetails());
	}
	
	private function sendEmail($device, $details)
	{
		$message = new MailMessage();
		$message
			->setTo($this->report)
			->setSender($this->sender)
			->setTemplate('AppBundle:It:device.email.twig', array('device' => $device, 'details' => $details));
		return $this->mailer->send($message);
	}
	
}
?>