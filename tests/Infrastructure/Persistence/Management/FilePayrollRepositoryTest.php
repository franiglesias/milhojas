<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\FilePayrollRepository;
use Milhojas\Infrastructure\Persistence\Management\PayrollFile;
use Tests\Infrastructure\Persistence\Management\Fixtures\PayrollFileSystem; 

use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
use Milhojas\Infrastructure\Utilities\TabDataParser;
use Milhojas\Infrastructure\Persistence\Management\Exceptions\InvalidPayrollData;
use Symfony\Component\Finder\Finder;

use org\bovigo\vfs\vfsStream;


class FilePayrollRepositoryTest extends \PHPUnit_Framework_Testcase
{
    private $root;
	private $finder;
	private $parser;

    public function setUp()
    {
		$this->root = (new PayrollFileSystem())->get();
		$this->finder = new PayrollFinder(new Finder());
		$this->parser = new TabDataParser(['id', 'email', 'gender', 'name', 'last']);
    }
	
	public function test_it_can_find_the_files()
	{
		$pathThatHasFiles = vfsStream::url('root/payroll');
		$repository = new FilePayrollRepository($pathThatHasFiles, $this->finder, $this->parser);
		$this->assertEquals(4, iterator_count($repository->getFiles('test')));
	}
	
	public function test_it_can_count_the_files()
	{
		$pathThatHasFiles = vfsStream::url('root/payroll');
		$repository = new FilePayrollRepository($pathThatHasFiles, $this->finder, $this->parser);
		// $repository->getFiles('test');
		$this->assertEquals(4, $repository->count('test'));
	}
	
	public function test_it_can_return_a_payroll_from_a_file()
	{
		$dataPath = vfsStream::url('root/payroll');
		$filepath = vfsStream::url('root/payroll/test/01_nombre_(apellido1 apellido2, nombre1 nombre2)_empresa_22308_trabajador_130496_010216_mensual.pdf');
		
		$repository = new FilePayrollRepository($dataPath, $this->finder, $this->parser);
		
		$payroll = $repository->get(new PayrollFile(new \SplFileInfo($filepath)));
		$this->assertInstanceOf('Milhojas\Domain\Management\Payroll', $payroll);
		$this->assertEquals('130496', $payroll->getId());
	}
	
	public function test_it_fails_if_a_id_does_not_exists_in_email_data()
	{
		$dataPath = vfsStream::url('root/payroll');
		$filepath = vfsStream::url('root/payroll/test/03_nombre_(apellido1 apellido2, nombre1)_empresa_22308_trabajador_130796_030216_mensual.pdf');
		
		$repository = new FilePayrollRepository($dataPath, $this->finder, $this->parser);
		
		$payroll = $repository->get(new PayrollFile(new \SplFileInfo($filepath)));
		$this->assertInstanceOf('Milhojas\Domain\Management\Payroll', $payroll);
		$this->assertEquals('130796', $payroll->getId());
		$this->assertEquals('Failed', $payroll->getName());
		$this->assertEquals('', $payroll->getEmail());
		$this->assertEquals('', $payroll->getGender());
	}
	
	
	
	/**
	 * @expectedException Milhojas\Infrastructure\Persistence\Management\Exceptions\InvalidPayrollData
	 */
	public function test_it_throws_exception_if_invalid_root()
	{
		$pathThatDoesNotExists = vfsStream::url('root/alt');
		$repository = new FilePayrollRepository($pathThatDoesNotExists, $this->finder, $this->parser);
	}

	/**
	 * @expectedException Milhojas\Infrastructure\Persistence\Management\Exceptions\InvalidPayrollData
	 */
	public function test_it_throws_exception_if_no_email_data_file_if_found()
	{
		$pathThatDoesNotHaveEmailDataFile = vfsStream::url('root/alternative');
		$repository = new FilePayrollRepository($pathThatDoesNotHaveEmailDataFile, $this->finder, $this->parser);
	}

	/**
	 * @expectedException Milhojas\Infrastructure\Persistence\Management\Exceptions\InvalidPayrollData
	 */
	public function test_it_throws_exception_if_no_folder_for_month_is_found()
	{
		$pathThatHasFiles = vfsStream::url('root/payroll');
		$repository = new FilePayrollRepository($pathThatHasFiles, $this->finder, $this->parser);
		$repository->getFiles('badmonth');
	}
	
	
}


?>