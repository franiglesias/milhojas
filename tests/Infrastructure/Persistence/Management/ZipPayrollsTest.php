<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\ZipPayrolls;
use Milhojas\Domain\Management\Employee;

use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem; 

use org\bovigo\vfs\vfsStream;
use Symfony\Component\Finder\Finder;

use Mmoreram\Extractor\Filesystem\SpecificDirectory;
use Mmoreram\Extractor\Resolver\ExtensionResolver;
use Mmoreram\Extractor\Extractor;

/**
* Description
*/
class ZipPayrollsTest extends \PHPUnit_Framework_Testcase
{
	
    private $root;

    public function setUp()
    {
		$this->root = '/Library/WebServer/Documents/milhojas/payroll';
    }
	
	public function test_it_loads_one_file_for_an_employee_with_one_payroll_codes()
	{
		$payrolls = new ZipPayrolls($this->root);
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(130065));
		$files = $payrolls->getByMonthAndEmployee('prueba', $employee);
		$this->assertEquals(1, count($files));
	}

	public function test_it_works_with_a_unique_archive()
	{
		$payrolls = new ZipPayrolls($this->root);
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(130065));
		$files = $payrolls->getByMonthAndEmployee('unique', $employee);
		$this->assertEquals(1, count($files));
	}


	public function test_it_loads_two_files_for_an_employee_with_two_payroll_codes()
	{
		$payrolls = new ZipPayrolls($this->root);
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(110011, 110024));
		$files = $payrolls->getByMonthAndEmployee('prueba', $employee);	
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
		$payrolls = new ZipPayrolls($this->root);
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(555555));
		$files = $payrolls->getByMonthAndEmployee('prueba', $employee);
	}
	
	/**
	 * @expectedException Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function test_it_throw_exception_if_no_repository_is_found()
	{
		$payrolls = new ZipPayrolls('/this/is/an/invalid/path');
	}

	/**
	 * @expectedException \Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryForMonthDoesNotExist
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function test_it_throw_exception_if_no_repository_for_month_is_found()
	{
		$payrolls = new ZipPayrolls($this->root);
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(130496));
		$files = $payrolls->getByMonthAndEmployee('invalid', $employee);
	}
	
	
}

?>
