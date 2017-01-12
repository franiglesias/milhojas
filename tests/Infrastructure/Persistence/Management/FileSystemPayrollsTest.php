<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\FileSystemPayrolls;
use Milhojas\Domain\Management\Employee;
use Milhojas\Domain\Management\PayrollMonth;
use Tests\Infrastructure\Persistence\Management\Fixtures\NewPayrollFileSystem;
use org\bovigo\vfs\vfsStream;

/**
 * Description.
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
        $payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/test/'));
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), '');
        $this->assertEquals(1, count($files));
    }

    public function test_payroll_repo_can_be_defined_relative_to_base_path()
    {
        $payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/'));
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), 'test');
        $this->assertEquals(1, count($files));
    }

    public function test_several_repos_can_be_defined()
    {
        $payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/'));
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345, 67890));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), array('test', 'other'));
        $this->assertEquals(3, count($files));
    }

    public function test_payroll_repo_can_be_defined_as_absolute_path()
    {
        $payrolls = new FileSystemPayrolls(vfsStream::url('root'));
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), 'payroll/test');
        $this->assertEquals(1, count($files));
    }

    public function test_it_loads_two_files_for_an_employee_with_two_payroll_codes()
    {
        $payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll/test'));
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345, 67890));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), '');
        $this->assertEquals(2, count($files));
    }

    /**
     * @expectedException  \Milhojas\Infrastructure\Persistence\Management\Exceptions\EmployeeHasNoPayrollFiles
     *
     * @author Fran Iglesias
     */
    public function test_it_throws_exception_is_employee_has_no_payroll_files()
    {
        $payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll'));
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(555555));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), 'test');
    }

    /**
     * @expectedException \Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist
     *
     * @author Fran Iglesias
     */
    public function test_it_throw_exception_if_no_repository_is_found()
    {
        $payrolls = new FileSystemPayrolls(vfsStream::url('root/another/'));
    }

    /**
     * @expectedException \Milhojas\Infrastructure\Persistence\Management\Exceptions\PayrollRepositoryDoesNotExist
     *
     * @author Fran Iglesias
     */
    public function test_it_throw_exception_if_no_repository_for_month_is_found()
    {
        $payrolls = new FileSystemPayrolls(vfsStream::url('root/payroll'));
        $employee = new Employee('user@example.com', 'Fran', 'Iglesias', 'male', array(12345));
        $files = $payrolls->getForEmployee($employee, new PayrollMonth('01', '2017'), 'invalid');
    }
}
