<?php

namespace Tests\Application\Management\Commands;

# SUT

use Milhojas\Application\Management\Commands\SendPayroll;
use Milhojas\Application\Management\Commands\SendPayrollHandler;

# Domain concepts
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollReporter;

# Repositories
use Milhojas\Infrastructure\Persistence\Management\FileSystemPayrolls;

# Components
use Symfony\Component\Finder\Finder;

# Application Messaging
use Milhojas\Library\EventBus\EventRecorder;

# Fixtures and Doubles

use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem; 
use org\bovigo\vfs\vfsStream;
use Tests\Utils\MailerStub;

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
	
	public function testItHandlesEmployeeWithOnePayrollDocument()
	{
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
		$command = new SendPayroll($employee, 'email@example.com', 'test', new PayrollReporter(1,2));
		$handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->recorder);
		$handler->handle($command);
		$this->assertTrue($this->mailer->wasCalled());
		$this->assertTrue($this->mailer->aMessageWasSentTo('user@example.com'));
		$this->assertEquals(1, $this->mailer->attachmentsInMessage());
		$this->assertEvent('PayrollEmailWasSent');
	}
	
	public function testItHandlesEmployeeWithNoDocuments()
	{
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(55555));
		$command = new SendPayroll($employee, 'email@example.com', 'test', new PayrollReporter(1,2));
		$handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->recorder);
		$handler->handle($command);
		$this->assertEvent('PayrollCouldNotBeFound');
	}
	
	public function testItHandlesMessageCouldNotBeSent()
	{
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
		$command = new SendPayroll($employee, 'email@example.com', 'test', new PayrollReporter(1,2));
		$handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->recorder);
		$this->mailer->makeFail();
		$handler->handle($command);
		$this->assertEvent('PayrollEmailCouldNotBeSent');
	}
	
	public function testItHandlesEmployeeWithSeveralFiles()
	{
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345, 67890));
		$command = new SendPayroll($employee, 'email@example.com', 'test', new PayrollReporter(1,2));
		$handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->recorder);
		$handler->handle($command);
		$this->assertTrue($this->mailer->wasCalled());
		$this->assertTrue($this->mailer->aMessageWasSentTo('user@example.com'));
		$this->assertEquals(2, $this->mailer->attachmentsInMessage());
		$this->assertEvent('PayrollEmailWasSent');
	}
	
	private function assertMailerIsCalledOneTime()
	{
		$this->assertEquals(1, $this->mailer->getTimesCalled());
	}
	
	private function assertMessageWasSentToThisEmail($email)
	{
		$this->assertTrue($this->mailer->messageTo($email));
	}
	
	public function assertEvent($event)
	{
		$events = $this->recorder->retrieve();
		$this->assertInstanceOf('\Milhojas\Domain\Management\Events\\'.$event, $events[0]);
	}
}

?>