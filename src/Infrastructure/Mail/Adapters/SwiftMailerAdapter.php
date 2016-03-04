<?php

namespace Milhojas\Infrastructure\Mail\Adapters;

use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\MailMessage;

class SwiftMailerAdapter implements MailerEngine {
	
	private $swift;
	
	public function __construct($swift)
	{
		$this->swift = $swift;
	}
	
	public function send(MailMessage $message) 
	{
		$swiftMessage = \Swift_Message::newInstance()
			->setSubject($message->getSubject())
			->setFrom($message->getSender())
			->setReplyTo($message->getReplyTo())
			->setTo($message->getTo())
			->setBody($message->getBody());
		foreach ($message->getParts as $part) {
			$swiftMessage->addPart($part['part'], $part['type']);
		}
		foreach ($message->getAttachments as $attachment) {
			$swiftMessage->attach(\Swift_Attachment::fromPath($attachment)
		}
		$this->swift->send($swiftMessage);
	}
	
}

?>