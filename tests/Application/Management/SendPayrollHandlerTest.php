<?php

namespace Tests\Application\Management;

# The SUT
use Milhojas\Application\Management\SendPayrollHandler;
use Milhojas\Application\Management\SendPayroll;

# Needed to check what happens in the FileSystem

use Symfony\Component\Finder\Finder;

# Test utilities, fixtures and mocks

use Tests\Utils\MailerStub;
use Tests\Utils\TemplatingStub;
use org\bovigo\vfs\vfsStream;
use Tests\Infrastructure\Persistence\Management\Fixtures\PayrollFileSystem; 

use Tests\Application\Management\Doubles\PayrollRepositoryMock;
use Tests\Application\Management\Doubles\PayrollFinderMock;



class SendPayrollHandlerTest extends \PHPUnit_Framework_Testcase
{
	public function setUp()
	{
		$this->root = (new PayrollFileSystem())->get();
		$this->mailer = new MailerStub();
		$this->repository = new PayrollRepositoryMock(vfsStream::url('root/payroll'), new PayrollFinderMock());
	}

	public function test_it_handles_the_command()
	{
		$command = new SendPayroll(array('sender@email.com' => 'Sender'), 'test');

		$handler = new SendPayrollHandler(
			$this->repository, 
			$this->mailer
		);

		$handler->handle($command);
		
		# assert severals outcomes of the command
		
		$this->assertRepositoryProducesPayrolls(3);

		$this->assertMailerSendsMessages(3);
		$this->assertAMessageWasSentTo('email1@example.com');
		$this->assertAMessageWasSentTo('email2@example.com');
		$this->assertAMessageWasSentTo('email3@example.com');
		
		$this->assertThatNoValidFilesRemain();
	}
	
	private function assertMailerSendsMessages($expected)
	{
		$this->assertEquals($expected, $this->mailer->getTimesCalled());
	}
	
	private function assertRepositoryProducesPayrolls($expected)
	{
		$this->assertEquals($expected, $this->repository->getTimesCalled());
	}
	
	private function assertAMessageWasSentTo($email)
	{
		$this->assertTrue($this->mailer->messageTo($email));
	}
	
	private function assertThatNoValidFilesRemain()
	{
		$finder = new Finder();
		$finder->files()->in(vfsStream::url('root/payroll/test'))->name('/nombre_\((.*), (.*)\).*trabajador_(\d+_\d+)/');
		$this->assertEquals(0, iterator_count($finder));
	}
}

?>