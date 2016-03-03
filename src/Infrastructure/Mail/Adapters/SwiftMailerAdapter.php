<?php

namespace Milhojas\Infrastructure\Mail\Adapters;

use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\Adapters\SwiftMessageAdapter;
use Milhojas\Infrastructure\Mail\MailMessage;

class SwiftMailerAdapter implements Mailer {
	
	private $swift;
	
	public function __construct($swift)
	{
		$this->swift = $swift;
	}
	
	public function send(MailMessage $message) 
	{
		$this->swift->send($message);
	}
	
	public function newMessage()
	{
		return new SwiftMessageAdapter();
	}
}

?>