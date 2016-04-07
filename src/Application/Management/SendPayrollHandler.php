<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;

use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
use Milhojas\Infrastructure\Mail\MailMessage;
use Milhojas\Infrastructure\Mail\Mailer;

use Milhojas\Library\EventSourcing\EventStream\EventRecorder;

# Events

use Milhojas\Domain\Management\Events\PayrollWasSent;
use Milhojas\Domain\Management\Events\PayrollCouldNotBeSent;

# Contracts

use Milhojas\Domain\Management\PayrollRepository;

# VO

use Milhojas\Library\ValueObjects\Misc\Progress;
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
		$files = $this->repository->getFiles($command->getMonth());
		$progress = new Progress(0, iterator_count($files));
		foreach ($files as $file) {
			$payroll = $this->repository->get(new PayrollFile($file));
			if ($payroll->getEmail()) {
				if ($this->sendEmail($payroll, $command->getSender(), $command->getMonth())) {
					$this->recorder->recordThat(new PayrollWasSent($payroll, $progress));
				    unlink($payroll->getFile());
				}
			} else {
				$this->recorder->recordThat(new PayrollCouldNotBeSent($payroll, $progress));
			}
			$progress = $progress->advance();
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