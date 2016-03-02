<?php

namespace Tests\Utils;

/**
* Simulates a Simple Mailer
*/
class MailerStub 
{
	private $times;
	private $message;
	
	public function send($message)
	{
		$this->times++;
		$this->message = array_merge((array)$this->message, $message->getTo());
		return true;
	}
	
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
		return isset($this->message[$email]);
	}
}

?>