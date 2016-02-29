<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\FilePayrollRepository;
use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
use Tests\Infrastructure\Persistence\Management\Fixtures\PayrollFileSystem; 

use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\InvalidPayrollData;
use Symfony\Component\Finder\Finder;

use org\bovigo\vfs\vfsStream;


class FilePayrollRepositoryTest extends \PHPUnit_Framework_Testcase
{
    private $root;

    public function setUp()
    {
		$this->root = (new PayrollFileSystem())->get();
    }
	
	public function test_it_builds()
	{
		$dataPath = vfsStream::url('root/payroll');
		
		$repository = new FilePayrollRepository($dataPath, new PayrollFinder(new Finder()));
		$this->assertInstanceOf('Milhojas\Infrastructure\Persistence\Management\PayrollFinder', $repository->finder());
	}
	
	public function test_it_returns_a_payroll_from_a_file()
	{
		$dataPath = vfsStream::url('root/payroll');
		$filepath = vfsStream::url('root/payroll/test/01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf');
		
		$repository = new FilePayrollRepository($dataPath, new PayrollFinder(new Finder()));
		$payroll = $repository->get(new PayrollFile(new \SplFileInfo($filepath)));
		$this->assertInstanceOf('Milhojas\Domain\Management\Payroll', $payroll);
		$this->assertEquals('130496_010216', $payroll->getId());
	}
	
	public function test_it_can_find_the_files()
	{
		$dataPath = vfsStream::url('root/payroll');
		$repository = new FilePayrollRepository($dataPath, new PayrollFinder(new Finder()));
		$repository->getFiles('test');
		$this->assertEquals(3, iterator_count($repository->finder()->getIterator()));
	}
	
	/**
	 * @expectedException Milhojas\Infrastructure\Persistence\Management\Exceptions\InvalidPayrollData
	 */
	public function test_it_throws_exception_if_invalid_root()
	{
		$dataPath = vfsStream::url('root/alt');
		$repository = new FilePayrollRepository($dataPath, new PayrollFinder(new Finder()));
	}


	/**
	 * @expectedException Milhojas\Infrastructure\Persistence\Management\Exceptions\InvalidPayrollData
	 */
	public function test_it_throws_exception_if_no_email_data_file_if_found()
	{
		$dataPath = vfsStream::url('root/alternative');
		$repository = new FilePayrollRepository($dataPath, new PayrollFinder(new Finder()));
	}



	/**
	 * @expectedException Milhojas\Infrastructure\Persistence\Management\Exceptions\InvalidPayrollData
	 */
	public function test_it_throws_exception_if_no_folder_for_month_is_found()
	{
		$dataPath = vfsStream::url('root/payroll');
		$repository = new FilePayrollRepository($dataPath, new PayrollFinder(new Finder()));
		$repository->getFiles('badmonth');
	}
	
	
}


?>