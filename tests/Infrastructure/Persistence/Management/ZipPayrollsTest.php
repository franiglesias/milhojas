<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\ZipPayrolls;
use Milhojas\Domain\Management\Employee;

use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem; 

use org\bovigo\vfs\vfsStream;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

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
		$this->root = getcwd().'/tests/Infrastructure/Persistence/Management/Fixtures/payroll';
    }
	
	public function test_it_loads_one_file_for_an_employee_with_one_payroll_codes()
	{
		$payrolls = new ZipPayrolls($this->root);
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
		$files = $payrolls->getForEmployee($employee, 'unique.zip', 'zipmonth');
		$this->assertEquals(1, count($files));
	}

	public function test_it_loads_two_files_for_an_employee_with_two_payroll_codes()
	{
		$payrolls = new ZipPayrolls($this->root);
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345, 67890));
		$files = $payrolls->getForEmployee($employee, ['zipmonth-1.zip', 'zipmonth-2.zip'], 'zipmonth');	
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
		$files = $payrolls->getForEmployee($employee, 'zipmonth-1.zip', 'zipmonth');
		
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
	 * @expectedException \Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist
	 *
	 * @return void
	 * @author Fran Iglesias
	 */
	public function test_it_throw_exception_if_no_repository_for_month_is_found()
	{
		$payrolls = new ZipPayrolls($this->root);
		$employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(130496));
		$files = $payrolls->getForEmployee($employee, 'invalid.zip', 'zipmonth');
	}
	
	public function tearDown()
	{
		(new FileSystem())->remove($this->root.'/zipmonth');
		(new FileSystem())->remove($this->root.'/unique');
	}
	
	
}

?>
