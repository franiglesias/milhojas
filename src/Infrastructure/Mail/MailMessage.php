<?php

namespace Milhojas\Infrastructure\Mail;

/**
* DTO to represent an email message
*/
class MailMessage
{
	private $subject;
	private $sender;
	private $replyTo;
	private $to;
	private $parts;
	private $attachments;
	
	public function __construct()
	{
		return $this;
	}
	
	public function setSubject($subject) {
		$this->subject = $subject;
		return $this;
	}
	public function getSubject()
	{
		return $this->subject;
	}
	
	public function setSender($sender) {
		$this->sender = $sender;
		return $this;
	}
	public function getSender()
	{
		return $this->sender;
	}
	
	public function setReplyTo($replyTo) {
		$this->replyTo = $replyTo;
		return $this;
	}
	public function getReplyTo()
	{
		return $this->replyTo;
	}
	
	public function setTo($to) {
		$this->to = $to;
		return $this;
	}
	public function getTo()
	{
		return $this->to;
	}
	
	public function setBody($body) {
		$this->body = $body;
		return $this;
	}
	public function getBody()
	{
		return $this->body;
	}
	
	public function addPart($part, $type) {
		$this->parts[] = array('part' => $part, 'type' => $type);
		return $this;
	}
	
	public function getParts()
	{
		return $this->parts;
	}
	
	public function attach($path) {
		$this->attachments[] = $path;
		return $this;
	}
	public function getAttachments()
	{
		return $this->attachments;
	}
	
	
}


?>