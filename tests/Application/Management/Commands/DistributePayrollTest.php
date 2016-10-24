<?php

namespace Tests\Application\Management\Commands;

# SUT

use Milhojas\Application\Management\Commands\DistributePayroll;
use Milhojas\Application\Management\Commands\DistributePayrollHandler;

# Domain concepts
// use Milhojas\Domain\Management\Employee;
// use Milhojas\Domain\Management\PayrollReporter;
use Milhojas\Domain\Management\Staff;

# Repositories
use Milhojas\Infrastructure\Persistence\Management\YamlStaff;

# Components
// use Symfony\Component\Finder\Finder;

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
		$command = new DistributePayroll('month', array('test'));
		$handler = new DistributePayrollHandler($this->staff, $this->sender, $this->bus);
		$this->sending($command)
			->toHandler($handler)
			->sendsCommand('Milhojas\Library\CommandBus\Commands\BroadcastEvent')
			->sendsCommand('Milhojas\Application\Management\SendPayroll');
	}

}

?>
