<?php

namespace Tests\Application\Management\Commands;

use Milhojas\Application\Management\Commands\SendPayroll;
use Milhojas\Application\Management\Commands\SendPayrollHandler;
use Milhojas\Domain\Management\Employee;
use Milhojas\Library\EventBus\EventRecorder;

use Tests\Utils\MailerStub;

use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem; 

use org\bovigo\vfs\vfsStream;
use Symfony\Component\Finder\Finder;

use Milhojas\Library\ValueObjects\Misc\Progress;

use Milhojas\Infrastructure\Persistence\Management\FileSystemPayrolls;
/**
* Description
*/
class SendPayrollTest extends \PHPUnit_Framework_Testcase
{
	private $mailer;
	private $recorder;
    private $root;
	private $payrolls;
	
	
	public function setUp()
	{
		$this->mailer = new MailerStub();
		$this->recorder = new EventRecorder();
		$this->root = (new NewPayrollFileSystem())->get();
		$this->payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/'), new Finder());
		
	}
	
	public function testHandler()
	{
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(130496));
		
		$command = new SendPayroll($employee, 'email@example.com', 'test', new Progress(1,2));
		$handler = new SendPayrollHandler($this->payrolls, $this->mailer, $this->recorder);
		
		$handler->handle($command);
		
	}
}

?>
