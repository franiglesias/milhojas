<?php

namespace Milhojas\Application\Contents;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
/**
* Handles events related to Device Status
*/
class EmailPostWasUpdated implements EventHandler
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
		$this->sendEmail($event->getTitle(), $event->getAuthor());
	}
	
	private function sendEmail($title, $author)
	{
		$message = new MailMessage();
		$message
			->setTo($this->report)
			->setSender($this->sender)
			->setTemplate('AppBundle:Contents:post.email.twig', array('title' => $title, 'author' => $author));
		return $this->mailer->send($message);
	}
	
}
?>