<?php

namespace Tests\Application\Management\Commands;

# SUT

use Milhojas\Application\Management\Commands\DistributePayroll;
use Milhojas\Application\Management\Commands\DistributePayrollHandler;

# Domain concepts
use Milhojas\Domain\Management\Staff;
use Milhojas\Domain\Management\PayrollMonth;

# Repositories
use Milhojas\Infrastructure\Persistence\Management\YamlStaff;


# Fixtures and Doubles

use Tests\Application\Utils\CommandScenario;
use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem;
use org\bovigo\vfs\vfsStream;
use Tests\Utils\MailerStub;


/**
* Description
*/
class DistributePayrollTest extends CommandScenario
{
	private $mailer;
	private $staff;
	private $sender;

	public function setUp()
	{
		parent::setUp();
		$this->mailer = new MailerStub();
		$this->sender = 'sender@example.com';
		$this->root = (new NewPayrollFileSystem())->get();
		$this->staff = new YamlStaff(vfsStream::url('root/payroll/staff.yml'));	
	}
	
	public function test_It_Handles_a_regular_distribution()
	{
		$command = new DistributePayroll(new PayrollMonth('enero', '2016'), array('test'));
		$handler = new DistributePayrollHandler($this->staff, $this->sender, $this->bus);
		$this->sending($command)
			->toHandler($handler)
			->sendsCommand('Milhojas\Application\Management\Commands\SendPayroll', 3)
			->sendsCommand('Milhojas\Library\Messaging\CommandBus\Command\BroadcastEvent', 2)
			->producesCommandHistory([
				'Milhojas\Library\Messaging\CommandBus\Command\BroadcastEvent',
				'Milhojas\Application\Management\Commands\SendPayroll',
				'Milhojas\Application\Management\Commands\SendPayroll',
				'Milhojas\Application\Management\Commands\SendPayroll',
				'Milhojas\Library\Messaging\CommandBus\Command\BroadcastEvent'
			])
		;
	}

}

?>
