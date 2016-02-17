<?php

namespace AppBundle\Command\Payroll\Reporter;
/**
* Description
*/
class EmailReporter extends ReporterDecorator
{
	private $mailer;
	private $to;
	
	function __construct($reporter, $mailer, $to)
	{
		parent::__construct($reporter);
		$this->mailer = $mailer;
		$this->to = $to;
	}
	
	public function report()
	{
		$lines = $this->reporter->report();
		$message = implode(chr(10), $lines);
		$this->send($message);
		return $lines;
	}
	
	private function send($body)
	{
		$message = \Swift_Message::newInstance()
			->setSubject(sprintf('Envío de Nóminas'))
			->setFrom('sistema@miralba.org')
			->setTo($this->to)
			->setBody($body);
		return $this->mailer->send($message);

	}
}

?>