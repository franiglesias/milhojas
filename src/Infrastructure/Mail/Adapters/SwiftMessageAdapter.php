<?php

namespace Milhojas\Infrastructure\Mail\Adapters;

use Milhojas\Infrastructure\Mail\MailMessage;

/**
* Description
*/
class SwiftMessageAdapter implements MailMessage, \Swift_Mime_Message
{
	private $message;
	
	public function __construct()
	{
		$this->message = \Swift_Message::newInstance();
		return $this;
	}
	
	public function setSubject($subject) {
		$this->message->setSubject($subject);
		return $this;
	}
	
	public function setFrom($sender, $name = null) {
		$this->message->setFrom($sender, $name);
		return $this;
	}
	
	public function setReplyTo($replyTo, $name = null) {
		$this->message->setReplyTo($replyTo, $name);
		return $this;
	}
	
	public function setTo($to, $name = null) {
		$this->message->setTo($to, $name);
		return $this;
	}
	
	public function setBody($body, $contentType = null) {
		$this->message->setBOdy($body, $contentType);
		return $this;
	}
	
	public function addPart($part, $type) {
		$this->message->addPart($part, $type);
		return $this;
	}
	
	public function attach($path) {
		$this->message->attach(\Swift_Attachment::fromPath($path));
		return $this;
	}
	
	public function getTo()
	{
		return $this->message->getTo();
	}
	
}


?>