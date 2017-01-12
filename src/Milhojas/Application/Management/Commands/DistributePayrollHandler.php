<?php

namespace Milhojas\Application\Management\Commands;

# Domain concepts

use Milhojas\Domain\Management\Staff;
use Milhojas\Domain\Management\PayrollReporter;

# Application Messaging infrastructure

use Milhojas\Application\Management\Commands\SendPayroll;
use Milhojas\Library\Messaging\CommandBus\Command\BroadcastEvent;

use Milhojas\Library\Messaging\CommandBus\Command;
use Milhojas\Library\Messaging\CommandBus\CommandHandler;

# Events

use Milhojas\Application\Management\Events\AllPayrollsWereSent;
use Milhojas\Application\Management\Events\PayrollDistributionStarted;

/**
* Distributes payroll documents for a month
*/
class DistributePayrollHandler implements CommandHandler
{
	private $bus;
	private $sender;
	private $staff;
	
	public function __construct(Staff $staff, $sender, $bus)
	{
		$this->bus = $bus;
		$this->staff = $staff;
		$this->sender = $sender;
	}
	
	public function handle(Command $command)
	{
		$progress = new PayrollReporter(0, $this->staff->countAll());
		$this->bus->execute(new BroadcastEvent(new PayrollDistributionStarted($progress)));
		foreach ($this->staff as $employee) {
			$progress = $progress->advance();
			$this->bus->execute( new SendPayroll($employee, $command->getMonth(), $command->getPaths(), $this->sender, $progress) );
		}
		$this->bus->execute(new BroadcastEvent(new AllPayrollsWereSent($progress, $command->getMonth())));
	}
}

?>
