<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;

use Milhojas\Library\EventBus\EventRecorder;

# Events

use Milhojas\Domain\Management\Events\PayrollWasSent;
use Milhojas\Domain\Management\Events\PayrollCouldNotBeSent;

# Contracts

use Milhojas\Domain\Management\PayrollRepository;

/**
* Manages SendPayroll command
*/

class SendPayrollHandler implements CommandHandler
{
	private $repository;
	private $mailer;
	private $templating;
	private $recorder;
	
	function __construct(PayrollRepository $repository, Mailer $mailer, EventRecorder $recorder)
	{
		$this->repository = $repository;
		$this->mailer = $mailer;
		$this->recorder = $recorder;
	}
	
	public function handle(Command $command)
	{
		foreach ($this->repository->getFiles($command->getMonth()) as $file) {
			$payroll = $this->repository->get(new PayrollFile($file));
			if ($payroll->getEmail()) {
				if ($this->sendEmail($payroll, $command->getSender(), $command->getMonth())) {
					$this->recorder->recordThat(new PayrollWasSent($payroll));
				    unlink($payroll->getFile());
				}
			} else {
				$this->recorder->recordThat(new PayrollCouldNotBeSent($payroll));
			}
		}
	}
	
	private function sendEmail($payroll, $sender, $month)
	{
		$message = new MailMessage();
		$message
			->setTo($payroll->getTo())
			->setSender($sender)
			->setTemplate('AppBundle:Management:payroll.email.twig', array('payroll' => $payroll, 'month' => $month))
			->attach($payroll->getFile()); 
		return $this->mailer->send($message);
	}
	
}

?>