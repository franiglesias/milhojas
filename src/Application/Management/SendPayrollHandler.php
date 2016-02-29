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
	private $dataPath;
	private $sender;
	
	function __construct($dataPath, PayrollRepository $repository, $mailer)
	{
		$this->dataPath = $dataPath;
		$this->repository = $repository;
		$this->mailer = $mailer;
	}
	
	public function handle(Command $command)
	{
		$this->repository->finder()->getFiles($this->dataPath.'/'.$command->getMonth());
		foreach ($this->repository->finder() as $file) {
			$file = new PayrollFile($file);
			$payroll = $this->repository->get($file);
			if (!$this->sendEmail($payroll, $command->getSender(), $command->getMonth())) {
				// $this->reporter->error('Problem with email: '.$payroll->getEmail());
			} else {
				// $this->reporter->add(sprintf('Email sent to %s.',$payroll->getName()));
				// $this->reporter->add('Deleting associated file.');
			    unlink($payroll->getFile());
			}
			// $progress->advance();
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