<?php

namespace Milhojas\Infrastructure\Mail;

use Milhojas\Infrastructure\Mail\MailerEngine;
use Milhojas\Infrastructure\Mail\MailMessage;
/**
* Description
*/
class Mailer
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