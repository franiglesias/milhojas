<?php

namespace Tests\Utils;

use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\MailMessage;
/**
* Simulates a Simple Mailer
*/
class MailerStub
{
	private $times;
	private $message;
	
	public function send(MailMessage $message)
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
	
	public function newMessage()
	{
		return new MessageAdapter();
	}
}



/**
* Description
*/
class MessageAdapter
{
	private $message;
	
	public function __construct()
	{
	}

	static public function newInstance()
	{
		return new static ();
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
		return $this;
	}
	
	public function setFrom($sender) {
		$this->sender = $sender;
		return $this;
	}
	
	public function setReplyTo($replyTo) {
		$this->replyto = $replyTo;
		return $this;
	}
	
	public function setTo($to) {
		$this->to = $to;
		return $this;
	}
	
	public function setBody($body) {
		$this->body = $body;
		return $this;
	}
	
	public function addPart($part, $type) {
		return $this;
	}
	
	public function attach($path) {
		return $this;
	}
	
	public function getTo()
	{
		return $this->to;
	}
	
}


?>