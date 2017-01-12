<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Milhojas\Infrastructure\Persistence\Management\ZipPayrolls;
use Symfony\Component\Filesystem\Filesystem;

/**
 * Description.
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
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), 'unique.zip');
        $this->assertEquals(1, count($files));
    }

    public function test_it_loads_two_files_for_an_employee_with_two_payroll_codes()
    {
        $payrolls = new ZipPayrolls($this->root);
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345, 67890));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), ['zipmonth-1.zip', 'zipmonth-2.zip']);
        $this->assertEquals(2, count($files));
    }

    /**
     * @expectedException  \Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles
     *
     * @author Fran Iglesias
     */
    public function test_it_throws_exception_is_employee_has_no_payroll_files()
    {
        $payrolls = new ZipPayrolls($this->root);
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(555555));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), 'zipmonth-1.zip');
    }

    /**
     * @expectedException \Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist
     *
     * @author Fran Iglesias
     */
    public function test_it_throw_exception_if_no_repository_is_found()
    {
        $payrolls = new ZipPayrolls('/this/is/an/invalid/path');
    }

    /**
     * @expectedException \Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist
     *
     * @author Fran Iglesias
     */
    public function test_it_throw_exception_if_no_repository_for_month_is_found()
    {
        $payrolls = new ZipPayrolls($this->root);
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(130496));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), 'invalid.zip');
    }

    public function tearDown()
    {
        (new FileSystem())->remove($this->root.'/zipmonth');
        (new FileSystem())->remove($this->root.'/unique');
        (new FileSystem())->remove($this->root.'/enero-2016');
    }
}
