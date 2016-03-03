<?php

namespace Milhojas\Infrastructure\Mail;

interface MailMessage {
	public function setSubject($subject);
	public function setFrom($sender);
	public function setReplyTo($replyTo);
	public function setTo($to);
	public function setBody($body);
	public function addPart($part, $type);
	public function attach($path);
}

?>