<?php

namespace Tests\Application\Management;

use Milhojas\Application\Management\SendPayrollHandler;
use Milhojas\Application\Management\SendPayroll;

use Milhojas\Domain\Management\Payroll;
use Milhojas\Domain\Management\PayrollRepository;
use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
use Symfony\Component\Finder\Finder;

use Tests\Infrastructure\Persistence\Management\Fixtures\PayrollFileSystem; 


use org\bovigo\vfs\vfsStream;

/**
* Simulates the Payroll Respository
*/

class PayrollStubRepository implements PayrollRepository {

	private $times;
	private $finder;
	private $root;
	
	private $responses;
	
	public function __construct($root, $finder)
	{
		$this->finder = $finder;
		$this->times = 0;
		$this->root = $root;
		$this->responses = array(
			1 => new Payroll(1, 'Name1 Lastname 1', 'email1@example.com', vfsStream::url('payroll/test/01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf')),
			2 => new Payroll(2, 'Name2 Lastname 2', 'email2@example.com', vfsStream::url('payroll/test/02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf')),
			3 => new Payroll(3, 'Name3 Lastname 3', 'email3@example.com', vfsStream::url('payroll/test/03_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130296_010216_mensual.pdf')),
 		);
	}
	
	public function get($file)
	{
		$this->times++;
		return $this->responses[$this->times];
	}
	
	public function getTimesCalled()
	{
		return $this->times;
	}
	
	public function finder()
	{
		return $this->finder;
	}
	
	public function getFiles($month)
	{
		$this->finder->getFiles($this->root.'/'.$month);
		return $this->finder;
	}
}

/**
* Simulates a Mailer
*/
class MailerStub 
{
	private $times;
	private $message;
	
	public function send($message)
	{
		$this->times++;
		$this->message = array_merge((array)$this->message, $message->getTo());
		return true;
	}
	
	public function getTimesCalled()
	{
		return $this->times;
	}
	
	public function getMessages()
	{
		return $this->message;
	}
	
	public function messageTo($email)
	{
		return isset($this->message[$email]);
	}
}

class SendPayrollHandlerTest extends \PHPUnit_Framework_Testcase
{
	public function setUp()
	{
		$this->root = (new PayrollFileSystem())->get();
		$this->mailer = new MailerStub();
		$this->repository = new PayrollStubRepository(vfsStream::url('payroll'), new PayrollFinder(new Finder));
	}

	public function test_it_handles_the_command()
	{
		
		$command = new SendPayroll(array('sender@email.com' => 'Sender'), 'test');

		$handler = new SendPayrollHandler(
			$this->repository, 
			$this->mailer
		);
		
		$handler->handle($command);

		$this->assertMailerSendsMessages(3);
		$this->assertRepositoryProducesPayrolls(3);
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
		$this->assertEquals(0, iterator_count($this->repository->getFiles('test')));
	}
}

?>