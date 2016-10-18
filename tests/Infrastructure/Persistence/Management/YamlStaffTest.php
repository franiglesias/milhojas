<?php

namespace Tests\Infrastructure\Persistence\Management;

// SUT

use Milhojas\Infrastructure\Persistence\Management\YamlStaff;

// Domain concepts

use Milhojas\Domain\Management\Staff;
use Milhojas\Domain\Management\Employee;

use Milhojas\Library\ValueObjects\Identity\Username;

// Test Utils

use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem; 
use org\bovigo\vfs\vfsStream;

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
			'email1@example.com', 
			'Nombre 1', 
			'Apellido 1', 
			'male', 
			array(130496, 130296)
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
