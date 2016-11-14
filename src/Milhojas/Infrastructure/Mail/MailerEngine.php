<?php

namespace Milhojas\Infrastructure\Mail;

use Milhojas\Infrastructure\Mail\MailMessage;

/**
 * A mailer engine implements sending emails
 *
 */

interface MailerEngine {
	public function send(MailMessage $message);
}

?>
