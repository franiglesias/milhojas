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
		return $this->mailer->sendWithTemplate(
			$sender,
			$payroll->getTo(), 'AppBundle:Management:payroll.email.twig',
			array(
				'payroll' => $payroll,
				'month' => $month
			),
			array($payroll->getFile())
		);
	}
	
}

?>