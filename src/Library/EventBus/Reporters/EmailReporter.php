<?php

namespace Milhojas\Library\EventBus\Reporters;

use Milhojas\Library\EventBus\Event;
use Milhojas\Library\EventBus\EventHandler;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;
/**
* An EmailReporter is a kind of EventHandler that can send emails
* 
* Sends an e email message to notify that some event has happened
*/
abstract class EmailReporter implements EventHandler
{
	private $mailer;
	private $sender;
	private $report;
	private $template;
	
	function __construct(Mailer $mailer, $sender, $report, $template)
	{
		$this->mailer = $mailer;
		$this->sender = $sender;
		$this->report = $report;
		$this->template = $template;
	}
	
	public function handle(Event $event)
	{
		$this->sendEmail($event);
	}
	/**
	 * Returns array of template parameters
	 *
	 * @param Event $event 
	 * @return void
	 * @author Francisco Iglesias Gómez
	 */
	abstract public function prepareTemplateParameters(Event $event);
	
	private function sendEmail($event)
	{
		$message = new MailMessage();
		$message
			->setTo($this->report)
			->setSender($this->sender)
			->setTemplate($this->template, $this->prepareTemplateParameters($event));
		return $this->mailer->send($message);
	}
	
}
?>