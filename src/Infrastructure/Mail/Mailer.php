<?php

namespace Milhojas\Infrastructure\Mail;

use Milhojas\Infrastructure\Mail\MailMessage;

/**
* A Mailer Service that can send email messages using a Mail Engine
*/

interface Mailer
{
	public function send(MailMessage $message);
}

?>