<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\PayrollFinder;
use Symfony\Component\Finder\Finder;


/**
* Description
*/
class PayrollFinderTest extends \PHPUnit_Framework_Testcase
{
	public function test_it_loads_files()
	{
		$finder = new PayrollFinder(new Finder());
		$finder->getFiles('/Library/WebServer/Documents/milhojas/payroll/test');
		$this->assertTrue(iterator_count($finder->getIterator()) > 0);
	}
	
}


?>