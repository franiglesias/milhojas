<?php

namespace Tests\Utils;

use Milhojas\Infrastructure\Mail\Mailer;
use Milhojas\Infrastructure\Mail\MailMessage;

/**
* Simulates a Simple Mailer for testing
*/

class MailerStub implements Mailer
{
	private $times;
	private $message;
	private $to;
	private $success = true;
	
	public function send(MailMessage $message)
	{
		if (! $this->success) {
			return false;
		}
		$this->times++;
		$this->message = $message;
		$this->to = $message->getTo();
		return true;
	}
	
	/**
	 * Simulate a fail in the Mailer system
	 * Resets in every new instance
	 *
	 * @return void
	 * @author Francisco Iglesias Gómez
	 */
	public function makeFail()
	{
		$this->success = false;
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

	# Mailer assertions
	
	public function attachmentsInMessage()
	{
		return count($this->message->getAttachments());
	}
	
	public function wasCalled($times = 1)
	{
		return $this->times == $times;
	}
	
	public function aMessageWasSentTo($email)
	{
		return in_array($email, $this->to);
	}
}


?>
