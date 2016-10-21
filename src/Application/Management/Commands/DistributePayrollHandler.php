<?php

namespace Milhojas\Application\Management\Commands;

use Milhojas\Application\Management\Commands\DistributePayroll;

# Domain concepts

use Milhojas\Domain\Management\Staff;
use Milhojas\Domain\Management\PayrollReporter;

# Application Messaging infrastructure

use Milhojas\Application\Management\Commands\SendPayroll;
use Milhojas\Library\CommandBus\Commands\BroadcastEvent;

use Milhojas\Library\CommandBus\Command;
use Milhojas\Library\CommandBus\CommandHandler;
# Events

use Milhojas\Domain\Management\Events\AllPayrollsWereSent;

/**
* Description
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
		foreach ($this->staff as $employee) {
			$progress = $progress->advance();
			$this->bus->execute( new SendPayroll($employee, $this->sender, $command->getMonth(), $progress) );
		}
		$this->bus->execute(new BroadcastEvent(new AllPayrollsWereSent($progress, $command->getMonth())));
	}
}

?>
