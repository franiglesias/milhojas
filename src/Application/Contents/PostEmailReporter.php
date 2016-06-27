<?php

namespace Milhojas\Application\Contents;

use Milhojas\Library\EventSourcing\Domain\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
/**
* Handles events related to Device Status
*/
class PostEmailReporter implements EventHandler
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
			->setTemplate($this->useTemplate($event), array(
				'id' => $event->getId(), 
				'title' => $event->getTitle(), 
				'author' => $event->getAuthor()
			));
		return $this->mailer->send($message);
	}
	
	private function useTemplate($event)
	{
		$eventName = $event->getName();
		switch ($eventName) {
			case 'contents.new_post_was_written':
				return 'AppBundle:Contents:post.created.email.twig';
				break;
				
			default:
				return 'AppBundle:Contents:post.updated.email.twig';
				break;
		}
	}
}
?>