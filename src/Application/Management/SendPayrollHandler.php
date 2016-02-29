<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;
use Milhojas\Domain\Management\PayrollRepository;
use Milhojas\Domain\Management\Payroll;
use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
use Milhojas\Infrastructure\Persistence\Management\PayrollFile;

use Milhojas\Infrastructure\Persistence\Management\Exceptions\MalformedPayrollFileName;
/**
* Manages SendPayroll command
*/
class SendPayrollHandler implements CommandHandler
{
	private $repository;
	private $mailer;
	private $sender;
	
	function __construct(PayrollRepository $repository, $mailer)
	{
		$this->repository = $repository;
		$this->mailer = $mailer;
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
	
	private function sendEmail($payroll, $sender, $month)
	{
		$message = \Swift_Message::newInstance()
			->setSubject(sprintf('Nómina de %s', $month))
			->setFrom($sender)
			->setReturnPath(key($sender))
			->setReplyTo(key($sender))
			->setSender(key($sender))
			->setTo($payroll->getTo())
			->setBody(sprintf('Estimado/a %s:'.chr(10).chr(10).'Adjuntamos tu nómina del mes de %s', $payroll->getName(), $month))
			->addPart(sprintf('<p>Estimado/a %s:</p><p>Adjuntamos tu nómina del mes de %s</p>', $payroll->getName(), $month), 'text/html')
			->attach(\Swift_Attachment::fromPath($payroll->getFile()));
		
		return $this->mailer->send($message);
	}
	
}

?>