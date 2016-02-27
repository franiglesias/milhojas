<?php

namespace Tests\Application\Management;

use Milhojas\Application\Management\SendPayrollHandler;
use Milhojas\Application\Management\SendPayroll;

use Milhojas\Domain\Management\Payroll;
use Milhojas\Domain\Management\PayrollRepository;
use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
use Symfony\Component\Finder\Finder;

use org\bovigo\vfs\vfsStream;

/**
* Simulates the Payroll Respository
*/

class PayrollStubRepository implements PayrollRepository {

	private $times;
	
	private $responses;
	
	public function __construct()
	{
		$this->times = 0;
		$this->responses = array(
			1 => new Payroll(1, 'Name1 Lastname 1', 'email1@example.com', '01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf'),
			2 => new Payroll(2, 'Name2 Lastname 2', 'email2@example.com', '02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf'),
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
		// Simulates file structure
		$structure = array(
			'email.dat' => '130496_010216'.chr(9).'email1@example.com'.chr(13)
							.'130286_010216'.chr(9).'email2@example.com'.chr(13),
			'test' => array(
				'01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf' => 'nothing' ,
				'02_nombre_(apellido3 apellido4, nombre3)_empresa_22308_trabajador_130286_010216_mensual.pdf' => 'nothing'
			)
		);
		$this->root = vfsStream::setup('payroll', null, $structure);
		
		$this->mailer = new MailerStub();
		$this->repository = new PayrollStubRepository();
	}

	public function test_it_handles_the_command()
	{
		
		$command = new SendPayroll(array('sender@email.com' => 'Sender'), 'test');

		$handler = new SendPayrollHandler(
			vfsStream::url('payroll'), 
			new PayrollFinder(new Finder), 
			$this->repository, 
			$this->mailer
		);
		
		$handler->handle($command);

		$this->assertMailerSendsMessages(2);
		$this->assertRepositoryProducesPayrolls(2);
		$this->assertAMessageWasSentTo('email1@example.com');
		$this->assertAMessageWasSentTo('email2@example.com');
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
}

?>