<?php

namespace Milhojas\Application\Management;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;
use Milhojas\Domain\Management\PayrollRepository;
use Milhojas\Domain\Management\Payroll;


/**
* Description
*/
class SendPayrollHandler extends CommandHandler
{
	private $finder;
	private $repository;
	
	function __construct(PayrollRepository $repository)
	{
		$this->repository = $repository;
	}
	
	public function handle(Command $command)
	{

	}
}

?>