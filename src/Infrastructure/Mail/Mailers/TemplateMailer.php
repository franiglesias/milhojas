<?php

namespace Milhojas\Infrastructure\Mail\Mailers;

# Contracts
use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Templating\Templating;

# DTO
use Milhojas\Infrastructure\Mail\MailMessage;

/**
* A BasicMailer Decorator that uses a templating system to send messages
*/

class TemplateMailer implements Mailer
{
	private $templating;
	private $mailer;
	
	public function __construct(Mailer $mailer, Templating $templating)
	{
		$this->mailer = $mailer;
		$this->templating = $templating;
	}
	
	public function send(MailMessage $message)
	{
		$template = $this->templating->loadTemplate($message->getTemplate());

		$message
			->setSubject($template->renderBlock('subject', $message->getData()))
			->setSender($message->getSender())
			->setReplyTo(key($message->getSender()))
			->setTo($message->getTo())
			->setBody($template->renderBlock('body_text', $message->getData()))
			->addPart($template->renderBlock('body_html', $message->getData()), 'text/html')
		;
		return $this->mailer->send($message);
	}
	
}

?>
