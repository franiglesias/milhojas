<?php

namespace Milhojas\Infrastructure\Mail;

use Milhojas\Infrastructure\Mail\MailerEngine;
use Milhojas\Infrastructure\Mail\MailMessage;

use Milhojas\Infrastructure\Templating\Templating;
/**
* Representes a Mailer Service
*/
class Mailer
{
	private $engine;
	private $templating;
	
	function __construct(MailerEngine $engine, Templating $templating)
	{
		$this->engine = $engine;
		$this->templating = $templating;
	}
	
	public function send(MailMessage $message)
	{
		return $this->engine->send($message);
	}
	
	public function sendWithTemplate($to, $from, $template, $data, $attachments = array())
	{
		$template = $this->templating->loadTemplate($template);

		$message = new MailMessage();
		$message
			->setSubject($template->renderBlock('subject',   $data))
			->setSender($from)
			->setReplyTo(key($from))
			->setTo($to)
			->setBody($template->renderBlock('body_text', $data))
			->addPart($template->renderBlock('body_html', $data), 'text/html')
		;
		
		foreach ((array)$attachments as $attachment) {
			$message->attach($attachment);
		}
		
		return $this->engine->send($message);
		
	}
}

?>