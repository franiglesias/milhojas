<?php

namespace Tests\Utils;

use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\MailMessage;
/**
* Simulates a Simple Mailer
*/
class MailerStub implements Mailer
{
	private $times;
	private $message;
	private $to;
	
	public function send(MailMessage $message)
	{
		$this->times++;
		$this->message = $message;
		$this->to = $message->getTo();
		return true;
	}
	
	# Test spy
	
	public function getTimesCalled()
	{
		return $this->times;
	}
	
	public function getMessages()
	{
		return $this->message;
	}
	
	public function messageTo($email)
	{
		return in_array($email, $this->to);
	}

}


?>
