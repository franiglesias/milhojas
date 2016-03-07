<?php

namespace Milhojas\Infrastructure\Mail\Mailers;

use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\MailerEngine;
use Milhojas\Infrastructure\Mail\MailMessage;

/**
* Barebones Mailer Service that can send email messages using a Mail Engine
*/

class BasicMailer implements Mailer
{
	private $engine;
	
	function __construct(MailerEngine $engine)
	{
		$this->engine = $engine;
	}
	
	public function send(MailMessage $message)
	{
		return $this->engine->send($message);
	}
	
}

?>