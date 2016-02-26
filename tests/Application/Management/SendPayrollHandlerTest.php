<?php

namespace Tests\Application\Management;

use Milhojas\Application\Management\SendPayrollHandler;
use Milhojas\Application\Management\SendPayroll;

use Milhojas\Domain\Management\Payroll;
use Milhojas\Domain\Management\PayrollRepository;
use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;

/**
* Description
*/

class PayrollStubRepository implements PayrollRepository {
	public function __construct()
	{
		
	}
	
	public function get($file)
	{
		return new Payroll('1', 'Name Lastname', 'email@example.com', 'datafile.pdf');
	}
}

/**
* Description
*/
class DummyFinder extends PayrollFinder
{
	public function __construct()
	{
		# code...
	}
}

/**
* Description
*/
class MailerStub 
{
	public function send()
	{
		return true;
	}
}

class SendPayrollHandlerTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_handles_the_command()
	{
		$command = new SendPayroll(array('sender@email.com' => 'Sender'), 'test');
		$dataPath = '/Library/WebServer/Documents/milhojas/payroll/test';
		$finder = new DummyFinder();
		$repository = new PayrollStubRepository();
		$mailer = new MailerStub();
		$handler = new SendPayrollHandler($dataPath, $finder, $repository, $mailer);
		$handler->handle($command);
	}
}

?>