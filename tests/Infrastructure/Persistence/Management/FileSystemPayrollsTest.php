<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\FileSystemPayrolls;
use Milhojas\Domain\Management\Employee;

use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem; 

use org\bovigo\vfs\vfsStream;

/**
* Description
*/
class FileSystemPayrollsTest extends \PHPUnit_Framework_Testcase
{
	
    private $root;

    public function setUp()
    {
		$this->root = (new NewPayrollFileSystem())->get();
    }
	
	public function test_it_loads_one_file_for_an_employee_with_one_payroll_codes()
	{
		$payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/'));
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(130496));
		$files = $payrolls->getByMonthAndEmployee('test', $employee);
		$this->assertEquals(1, count($files));
	}

	public function test_it_loads_two_files_for_an_employee_with_two_payroll_codes()
	{
		$payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/'));
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(130286, 130496));
		$files = $payrolls->getByMonthAndEmployee('test', $employee);
		$this->assertEquals(2, count($files));
	}

	/**
	 * @expectedException  Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function test_it_throws_exception_is_employee_has_no_payroll_files()
	{
		$payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/'));
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(110324));
		$files = $payrolls->getByMonthAndEmployee('test', $employee);
	}
	
}

?>
