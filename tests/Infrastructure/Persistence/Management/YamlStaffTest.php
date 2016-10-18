<?php

namespace Tests\Infrastructure\Persistence\Management;

// SUT

use Milhojas\Infrastructure\Persistence\Management\YamlStaff;

// Domain concepts

use Milhojas\Domain\Management\Staff;
use Milhojas\Domain\Management\Employee;

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
		$this->assertEquals($expected, $staff->getEmployeeByUsername('email1@example.com'));
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
		$staff->getEmployeeByUsername('invalid@example.com');
	}
	
	
}

?>
