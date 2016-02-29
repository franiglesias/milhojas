<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
use Symfony\Component\Finder\Finder;

use Tests\Infrastructure\Persistence\Management\Fixtures\PayrollFileSystem; 

use org\bovigo\vfs\vfsStream;

/**
* Description
*/
class PayrollFinderTest extends \PHPUnit_Framework_Testcase
{
	
    private $root;

    public function setUp()
    {
		$this->root = (new PayrollFileSystem())->get();
    }

	
	public function test_it_loads_files()
	{
		$finder = new PayrollFinder(new Finder());
		$finder->getFiles(vfsStream::url('payroll/test'));
		
		$this->assertEquals(4, iterator_count($finder->getIterator()));
	}
	
}


?>