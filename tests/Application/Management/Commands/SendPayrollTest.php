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

# Fixtures and Doubles

use Tests\Application\Utils\CommandScenario;
use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem; 
use org\bovigo\vfs\vfsStream;
use Tests\Utils\MailerStub;

class SendPayrollTest extends CommandScenario
{
	private $mailer;
	private $root;
	private $payrolls;

	public function setUp()
	{
		parent::setUp();
		$this->mailer = new MailerStub();
		$this->root = (new NewPayrollFileSystem())->get();
		$this->payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/'));
	}
	
	public function testItHandlesEmployeeWithOnePayrollDocument()
	{
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
		$command = new SendPayroll($employee, 'test', 'email@example.com', 'test', new PayrollReporter(1,2));
		$handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->recorder);
		
		$this->sending($command)
			->toHandler($handler)
			->raisesEvent('Milhojas\Domain\Management\Events\PayrollEmailWasSent')
			->produces($this->mailer->wasCalled())
			->produces($this->mailer->aMessageWasSentTo('user@example.com'))
			->produces($this->mailer->attachmentsInMessage() === 1)
		;
					
	}
	
	public function testItHandlesEmployeeWithNoDocuments()
	{
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(55555));
		$command = new SendPayroll($employee, 'test', 'email@example.com', 'test', new PayrollReporter(1,2));
		$handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->recorder);

		$this->sending($command)
			->toHandler($handler)
			->raisesEvent('Milhojas\Domain\Management\Events\PayrollCouldNotBeFound');
	}
	
	public function testItHandlesMessageCouldNotBeSent()
	{
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
		$command = new SendPayroll($employee, 'test', 'email@example.com', 'test', new PayrollReporter(1,2));
		$handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->recorder);
		$this->mailer->makeFail();

		$this->sending($command)
			->toHandler($handler)
			->raisesEvent('\Milhojas\Domain\Management\Events\PayrollEmailCouldNotBeSent');
	}
	
	public function testItHandlesEmployeeWithSeveralFiles()
	{
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345, 67890));
		$command = new SendPayroll($employee, 'test', 'email@example.com', 'test',  new PayrollReporter(1,2));
		$handler = new SendPayrollHandler($this->payrolls, 'AppBundle:Management:payroll_document.email.twig', $this->mailer, $this->recorder);
		$this->sending($command)
			->toHandler($handler)
			->raisesEvent('Milhojas\Domain\Management\Events\PayrollEmailWasSent')
			->produces($this->mailer->wasCalled())
			->produces($this->mailer->aMessageWasSentTo('user@example.com'))
			->produces($this->mailer->attachmentsInMessage() === 2);
	}
	
}

?>
