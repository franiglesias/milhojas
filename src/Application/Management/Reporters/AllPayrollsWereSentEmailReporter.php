<?php

namespace Milhojas\Application\Management\Reporters;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
/**
* Responds to PostWasUpdated Event
* 
* Sends an e email message to notify that a post has been updated
*/
class AllPayrollsWereSentEmailReporter implements EventHandler
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
		$this->sendEmail($event);
	}
	
	private function sendEmail($event)
	{
		$message = new MailMessage();
		$message
			->setTo($this->report)
			->setSender($this->sender)
			->setTemplate('AppBundle:Management:all_payrolls.sent.email.twig', array(
				'month' => $event->getMonth(), 
				'sent'  => $event->getProgress()->getCurrent(), 
				'total' => $event->getProgress()->getTotal()
			));
		return $this->mailer->send($message);
	}
	
}
?>