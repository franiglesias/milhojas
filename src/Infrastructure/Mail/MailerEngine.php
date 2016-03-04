<?php

namespace Milhojas\Infrastructure\Mail;

use Milhojas\Infrastructure\Mail\MailMessage;

interface MailerEngine {
	public function send(MailMessage $message);
}

?>