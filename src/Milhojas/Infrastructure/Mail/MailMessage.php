<?php

namespace Milhojas\Infrastructure\Mail;

/**
* DTO to represent an email message that can use a template
*/
class MailMessage
{
	private $subject;
	private $sender;
	private $replyTo;
	private $to;
	private $parts;
	private $attachments;
	private $body;
	private $template;
	private $data;
	
	public function __construct()
	{
		$this->attachments = array();
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
		$this->to = (array)$to;
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
		$this->attachments = array_merge($this->attachments, (array)$path);
		return $this;
	}
	public function getAttachments()
	{
		if (!$this->attachments) {
			return array();
		}
		return $this->attachments;
	}
	
	public function setTemplate($template, array $data = array())
	{
		$this->template = $template;
		$this->data = $data;
		return $this;
	}
	public function getTemplate()
	{
		return $this->template;
	}
	public function getData()
	{
		return $this->data;
	}
	
}


?>
