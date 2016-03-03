<?php

namespace Milhojas\Infrastructure\Mail;

use Milhojas\Infrastructure\Mail\MailMessage;

interface Mailer {
	public function send(MailMessage $message);
}

?>