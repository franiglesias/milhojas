<?php

namespace Tests\Infrastructure\Persistence\Management;

// SUT

use Milhojas\Domain\Management\Employee;
use Milhojas\Infrastructure\Persistence\Management\YamlStaff;
use Milhojas\Library\ValueObjects\Identity\Email;
use Milhojas\Library\ValueObjects\Identity\Username;
use Milhojas\Library\ValueObjects\Misc\Gender;
use org\bovigo\vfs\vfsStream;
use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem;


// Domain concepts

// Test Utils

/**
* Test the YamlStaff Employee data repository
*/
class YamlStaffTest extends \PHPUnit_Framework_Testcase
{
    private $root;

    public function setUp()
    {
		$this->root = (new NewPayrollFileSystem())->get();
    }

	public function testItAutoLoadsUsersAndShouldContain3Users()
	{
		$staff = new YamlStaff(vfsStream::url('root/payroll/staff.yml'));
		$this->assertEquals(3, $staff->countAll());
	}
	
	public function testItIterates()
	{
		$staff = new YamlStaff(vfsStream::url('root/payroll/staff.yml'));
		foreach ($staff as $employee) {
			$this->assertInstanceOf('Milhojas\Domain\Management\Employee', $employee);
		}
	}
	
	public function testItCanRetrieveAnEmployeeUsingUsername()
	{
		$staff = new YamlStaff(vfsStream::url('root/payroll/staff.yml'));
		$expected = new Employee(
            new Email('email1@example.com'),
            'Nombre 1',
            'Apellido 1',
            new Gender('male'),
            array(12345, 67890)
		);
		$this->assertEquals($expected, $staff->getEmployeeByUsername(new Username('email1@example.com')));
	}
	
	public function testItCanGetAllEmployees()
	{
		$staff = new YamlStaff(vfsStream::url('root/payroll/staff.yml'));
		$all = $staff->findAll();
		$this->assertEquals(3, count($all));
	}
	
	/**
	 * @expectedException Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeCouldNotBeFound
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function testItThrowsExceptionIfEmployeeDoesNotExists()
	{
		$staff = new YamlStaff(vfsStream::url('root/payroll/staff.yml'));
		$staff->getEmployeeByUsername(new Username('invalid@example.com'));
	}
	
}

?>
