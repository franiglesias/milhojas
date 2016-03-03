<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
// use Milhojas\Infrastructure\Persistence\Management\Exceptions\MalformedPayrollFileName;

# Contracts

use Milhojas\Domain\Management\PayrollRepository;
use Milhojas\Infrastructure\Templating\Templating;

/**
* Manages SendPayroll command
*/

class SendPayrollHandler implements CommandHandler
{
	private $repository;
	private $mailer;
	private $templating;
	
	function __construct(PayrollRepository $repository, $mailer, Templating $templating)
	{
		$this->repository = $repository;
		$this->mailer = $mailer;
		$this->templating = $templating;
	}
	
	public function handle(Command $command)
	{
		foreach ($this->repository->getFiles($command->getMonth()) as $file) {
			$payroll = $this->repository->get(new PayrollFile($file));
			if ($this->sendEmail($payroll, $command->getSender(), $command->getMonth())) {
			    unlink($payroll->getFile());
			}
		}
	}
	
	// Uses this tip to have two email versions in one template
	// http://alexandre-salome.fr/blog/Generate-Mails-With-templating
	
	private function sendEmail($payroll, $sender, $month)
	{
		$template = $this->templating->loadTemplate('AppBundle:Management:payroll.email.twig');
		$parameters  = array(
		    'payroll' => $payroll,
			'month' => $month
		);

		$message = \Swift_Message::newInstance()
			->setSubject($template->renderBlock('subject',   $parameters))
			->setFrom($sender)
			->setReplyTo(key($sender))
			->setTo($payroll->getTo())
			->setBody($template->renderBlock('body_text', $parameters))
			->addPart($template->renderBlock('body_html', $parameters), 'text/html')
			->attach(\Swift_Attachment::fromPath($payroll->getFile()));
		
		return $this->mailer->send($message);
	}
	
}

?>