<?php

namespace Milhojas\Application\Contents\Reporters;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
/**
* Responds to NewPostWasWritten Event
* 
* Sends an email message to notify that a new post was written
*/
class NewPostWasWrittenReporter implements EventHandler
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
			->setTemplate('AppBundle:Contents:post.created.email.twig', array(
				'id' => $event->getId(), 
				'title' => $event->getTitle(), 
				'author' => $event->getAuthor()
			));
		return $this->mailer->send($message);
	}
	
}
?>