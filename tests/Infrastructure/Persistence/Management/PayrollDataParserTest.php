<?php

namespace Tests\Infrastructure\Persistence\Management;

use Milhojas\Infrastructure\Persistence\Management\PayrollDataParser;
use Tests\Infrastructure\Persistence\Management\Fixtures\PayrollFileSystem; 

use org\bovigo\vfs\vfsStream;
/**
* Description
*/
class PayrollDataParserTest extends \PHPUnit_Framework_Testcase
{
    private $root;

    public function setUp()
    {
		$this->root = (new PayrollFileSystem())->get();
    }
	
	public function test_it_loads_data_from_tab_file()
	{
		$parser = new PayrollDataParser();
		$parser->createFromTab(vfsStream::url('root/payroll/email.dat'));
		$expected = array(
			'130496' => array('email' => 'email1@example.com', 'gender' => 'male', 'name' => 'Nombre', 'last' => 'Apellido'),
			'130286' => array('email' => 'email2@example.com', 'gender' => 'female', 'name' => 'Nombre. 2', 'last' => 'Apellido. 2'),
			'130296' => array('email' => 'email3@example.com', 'gender' => 'female', 'name' => 'Nombre 3', 'last' => 'Apellido 3')	
		);
		$this->assertEquals($expected, $parser->getData());
	}
}

?>
